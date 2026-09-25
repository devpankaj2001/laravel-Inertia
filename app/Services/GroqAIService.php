<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqAIService
{
    protected const API_URL = 'https://api.groq.com/openai/v1/chat/completions';
    protected const DEFAULT_MODEL = 'qwen/qwen3.8-27b';

    /**
     * Send chat completion request to Groq Cloud (Free Tier)
     *
     * @param array $messages Array of ['role' => 'user'|'assistant'|'system', 'content' => '...']
     * @param string|null $model
     * @param float $temperature
     * @param int $maxTokens
     * @return string|null
     */
    public static function chat(
        array $messages,
        ?string $model = null,
        float $temperature = 0.55,
        int $maxTokens = 400
    ): ?string {
        $rawKey = config('services.groq.key') ?: env('GROQ_API_KEY');
        $apiKey = trim((string) $rawKey);

        if (empty($apiKey)) {
            Log::info('GroqAIService: No GROQ_API_KEY configured.');
            return null;
        }

        $modelsToTry = array_filter([
            $model,
            config('services.groq.model'),
            env('GROQ_MODEL'),
            'qwen/qwen3.8-27b',
            'openai/gpt-oss-120b',
            'openai/gpt-oss-20b',
        ]);
        $modelsToTry = array_values(array_unique($modelsToTry));

        foreach ($modelsToTry as $chosenModel) {
            try {
                $http = Http::timeout(15);
                if (app()->environment('local')) {
                    $http = $http->withoutVerifying();
                }

                // If reasoning model (gpt-oss), allocate more tokens to account for reasoning_tokens overhead
                $effectiveTokens = str_contains($chosenModel, 'gpt-oss') ? max($maxTokens, 650) : $maxTokens;

                $response = $http->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])->post(self::API_URL, [
                    'model' => $chosenModel,
                    'messages' => $messages,
                    'temperature' => $temperature,
                    'max_tokens' => $effectiveTokens,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $finish = $data['choices'][0]['finish_reason'] ?? '';
                    $content = trim((string) ($data['choices'][0]['message']['content'] ?? ''));

                    // Guardrail: reject truncated fragments (e.g. less than 40 chars or cut off by length)
                    if (!empty($content) && strlen($content) >= 40 && $finish !== 'length') {
                        return $content;
                    }

                    Log::warning("GroqAIService model [{$chosenModel}] returned incomplete output (chars: " . strlen($content) . ", finish: {$finish}), trying next model.");
                } else {
                    Log::warning("GroqAIService model [{$chosenModel}] failed with status {$response->status()}: " . $response->body());
                }
            } catch (\Throwable $e) {
                Log::warning("GroqAIService exception for model [{$chosenModel}]: " . $e->getMessage());
            }
        }

        return null;
    }

    /**
     * Stream Groq response via Server-Sent Events (SSE) callback
     */
    public static function streamChat(
        array $messages,
        callable $onChunk,
        ?string $model = null
    ): bool {
        $rawKey = config('services.groq.key') ?: env('GROQ_API_KEY');
        $apiKey = trim((string) $rawKey);
        if (empty($apiKey)) {
            return false;
        }

        $chosenModel = $model ?: (config('services.groq.model') ?: (env('GROQ_MODEL') ?: self::DEFAULT_MODEL));

        try {
            $ch = curl_init(self::API_URL);
            $payload = json_encode([
                'model' => $chosenModel,
                'messages' => $messages,
                'temperature' => 0.55,
                'max_tokens' => 250,
                'stream' => true,
            ]);

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($ch, $data) use ($onChunk) {
                $lines = explode("\n", $data);
                foreach ($lines as $line) {
                    $trimmed = trim($line);
                    if (str_starts_with($trimmed, 'data: ')) {
                        $json = substr($trimmed, 6);
                        if ($json === '[DONE]') {
                            $onChunk(null, true);
                            break;
                        }
                        $decoded = json_decode($json, true);
                        $delta = $decoded['choices'][0]['delta']['content'] ?? '';
                        if ($delta !== '') {
                            $onChunk($delta, false);
                        }
                    }
                }
                return strlen($data);
            });
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $result = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

            return empty($err);
        } catch (\Throwable $e) {
            Log::error('GroqAIService stream error: ' . $e->getMessage());
            return false;
        }
    }
}
