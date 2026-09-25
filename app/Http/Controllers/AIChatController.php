<?php

namespace App\Http\Controllers;

use App\Models\AIConversation;
use App\Models\Inquiry;
use App\Services\AIService;
use App\Services\GroqAIService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AIChatController extends Controller
{
    /**
     * Handle incoming chat message from AI Assistant (JSON)
     */
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1500',
            'session_id' => 'nullable|string|max:64',
            'history' => 'nullable|array',
            'history.*.role' => 'nullable|string',
            'history.*.text' => 'nullable|string',
        ]);

        $userMessage = trim($validated['message']);
        $history = $validated['history'] ?? [];
        $sessionId = $validated['session_id'] ?? $request->header('X-Session-ID') ?? session()->getId();

        $clientIp = \App\Services\GeoIPService::getClientIp($request);
        $country = \App\Services\GeoIPService::getCountry($clientIp, $request);

        try {
            $response = AIService::generateReply($userMessage, $history, $sessionId, $clientIp, $country);

            return response()->json([
                'success' => true,
                'reply' => $response['reply'],
                'provider' => $response['provider'] ?? 'free-tier',
                'quick_replies' => $response['quick_replies'] ?? [],
                'lead_captured' => $response['lead_captured'] ?? false,
                'session_id' => $sessionId,
            ]);
        } catch (\Throwable $e) {
            Log::error('AIChatController error: ' . $e->getMessage());

            return response()->json([
                'success' => true,
                'reply' => "Thank you for reaching out! Our principal architect is available to review your project requirements. You can reach us at " . config('site.email', 'info@webranker.in') . " or click 'Schedule Consultation' below.",
                'provider' => 'fallback',
                'quick_replies' => [
                    ['label' => 'Schedule Consultation', 'action' => 'consult'],
                    ['label' => 'Claim Free Audit', 'action' => 'audit'],
                ],
                'session_id' => $sessionId,
            ]);
        }
    }

    /**
     * Real-time Streaming SSE Endpoint for AI Assistant
     */
    public function stream(Request $request): StreamedResponse
    {
        $message = trim((string) $request->query('message', ''));
        $sessionId = (string) $request->query('session_id', session()->getId());

        $groqKey = config('services.groq.key') ?: env('GROQ_API_KEY');

        return response()->stream(function () use ($message, $sessionId, $groqKey) {
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            header('Connection: keep-alive');
            header('X-Accel-Buffering: no');

            if (empty($message)) {
                echo "data: " . json_encode(['done' => true]) . "\n\n";
                ob_flush();
                flush();
                return;
            }

            // Guardrail 1: Vague or invalid
            if (\App\Services\RAGService::isVagueOrInvalid($message)) {
                $reply = \App\Services\RAGService::getInvalidQueryResponse($message);
                echo "data: " . json_encode(['chunk' => $reply]) . "\n\n";
                echo "data: " . json_encode(['done' => true]) . "\n\n";
                if (ob_get_level() > 0) ob_flush();
                flush();
                return;
            }

            // Guardrail 2: Strictly block off-topic queries
            if (\App\Services\RAGService::isOffTopic($message)) {
                $reply = \App\Services\RAGService::getOffTopicRefusal($message);
                echo "data: " . json_encode(['chunk' => $reply]) . "\n\n";
                echo "data: " . json_encode(['done' => true]) . "\n\n";
                if (ob_get_level() > 0) ob_flush();
                flush();
                return;
            }

            // Grounded RAG context retrieval
            $ragResult = \App\Services\RAGService::retrieveContext($message);
            $ragContext = $ragResult['formatted_context'];

            if (!empty($groqKey)) {
                $messages = [
                    ['role' => 'system', 'content' => AIService::getSystemPrompt($ragContext)],
                    ['role' => 'user', 'content' => $message],
                ];

                $streamSuccess = GroqAIService::streamChat($messages, function (?string $chunk, bool $done) {
                    if ($done) {
                        echo "data: " . json_encode(['done' => true]) . "\n\n";
                    } elseif ($chunk !== null) {
                        echo "data: " . json_encode(['chunk' => $chunk]) . "\n\n";
                    }
                    if (ob_get_level() > 0) {
                        ob_flush();
                    }
                    flush();
                });

                if ($streamSuccess) {
                    return;
                }
            }

            // Fallback: Stream Local Expert Engine response word-by-word
            $reply = AIService::generateLocalExpertReply($message);
            $words = preg_split('/(\s+)/', $reply, -1, PREG_SPLIT_DELIM_CAPTURE);
            foreach ($words as $word) {
                echo "data: " . json_encode(['chunk' => $word]) . "\n\n";
                if (ob_get_level() > 0) {
                    ob_flush();
                }
                flush();
                usleep(30000); // 30ms typing cadence
            }

            echo "data: " . json_encode(['done' => true]) . "\n\n";
            if (ob_get_level() > 0) {
                ob_flush();
            }
            flush();
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    /**
     * Retrieve conversation history for this session
     */
    public function history(Request $request, string $sessionId): JsonResponse
    {
        $history = AIService::getHistory($sessionId);

        return response()->json([
            'success' => true,
            'session_id' => $sessionId,
            'messages' => $history,
        ]);
    }

    /**
     * Capture direct lead submitted from inside the chat widget
     */
    public function captureLead(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:50',
            'message' => 'nullable|string|max:1000',
            'session_id' => 'nullable|string|max:64',
        ]);

        try {
            $clientIp = \App\Services\GeoIPService::getClientIp($request);
            $country = \App\Services\GeoIPService::getCountry($clientIp, $request);

            $conversation = null;
            if (!empty($validated['session_id'])) {
                $conversation = AIConversation::updateOrCreate(
                    ['session_id' => $validated['session_id']],
                    [
                        'lead_name' => $validated['name'],
                        'lead_email' => $validated['email'],
                        'lead_phone' => $validated['phone'] ?? null,
                        'ip_address' => $clientIp,
                        'country' => $country,
                    ]
                );
            }

            $inquiry = Inquiry::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? 'Via AI Chat',
                'company' => 'Direct AI Chat Lead',
                'service_interest' => 'AI Chatbot Inbound Lead',
                'budget' => 'Discussed via AI Chat',
                'message' => $validated['message'] ?? 'Lead submitted via WebRanker AI Assistant',
                'ip_address' => $clientIp,
                'country' => $country,
                'status' => 'new',
                'conversation_id' => $conversation?->id,
                'session_id' => $validated['session_id'] ?? null,
            ]);

            // Feature 3: Score inbound AI Chat lead in background
            \App\Jobs\ScoreLeadJob::dispatchAfterResponse($inquiry->id);

            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your consultation request has been received. Our senior architect will review your project and connect within 24 hours.',
                'lead_id' => $inquiry->id,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to capture AI chat lead: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Unable to save lead at this time. Please use our consultation form.',
            ], 500);
        }
    }
}
