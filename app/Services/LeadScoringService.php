<?php

namespace App\Services;

use App\Models\Inquiry;
use Illuminate\Support\Facades\Log;

class LeadScoringService
{
    /**
     * Analyze and score an inbound inquiry using Groq AI with deterministic fallback.
     *
     * @param Inquiry $inquiry
     * @return Inquiry
     */
    public static function scoreInquiry(Inquiry $inquiry): Inquiry
    {
        $conversationHistory = '';
        if ($inquiry->conversation) {
            $recentMsgs = $inquiry->conversation->messages()->latest()->take(4)->get()->reverse();
            foreach ($recentMsgs as $m) {
                $conversationHistory .= ucfirst($m->role) . ": " . substr($m->content, 0, 150) . "\n";
            }
        }

        $prompt = <<<EOT
You are WebRanker's Senior Sales & Technical Strategy Director.
Analyze this inbound client inquiry and score its commercial intent, urgency, and estimated value.

INQUIRY DETAILS:
- Name: {$inquiry->name}
- Email: {$inquiry->email}
- Phone: {$inquiry->phone}
- Company: {$inquiry->company}
- Service Interest: {$inquiry->service_interest}
- Stated Budget: {$inquiry->budget}
- Message / Scope: {$inquiry->message}
- Country: {$inquiry->country}
{$conversationHistory}

SCORING RULES:
- Score 85-100 ('enterprise'): Custom architectures, enterprise web apps, high budgets ($3k+), corporate domains, multi-service scopes.
- Score 65-84 ('hot'): Clear web development, redesign, ecommerce, technical SEO requirements with strong purchase intent.
- Score 40-64 ('warm'): Early-stage inquiries, vague requirements, lower budgets or general tech questions.
- Score 0-39 ('spam' or 'cold'): Link insertions, job seekers, spam, gibberish, or completely non-commercial requests.

Respond with ONLY valid JSON formatted exactly like this:
{
  "score": 85,
  "intent": "enterprise",
  "summary": "Client needs custom Next.js & Laravel platform with high-speed performance.",
  "suggested_reply": "Hi Sarah,\\n\\nThank you for reaching out to WebRanker! We would love to engineer your custom web platform. Our team specializes in sub-second Next.js architectures and robust Laravel APIs designed for scale.\\n\\nAre you free for a quick 15-minute scoping call tomorrow, or would you prefer connecting directly on WhatsApp (+91 97185 70218)?\\n\\nBest regards,\\nWebRanker Strategy Team"
}
EOT;

        $messages = [
            ['role' => 'system', 'content' => 'You are an elite B2B tech sales evaluator. Output ONLY strict JSON.'],
            ['role' => 'user', 'content' => $prompt],
        ];

        try {
            $response = GroqAIService::chat($messages, 'qwen/qwen3.8-27b', 0.3, 500);

            if ($response) {
                $cleanJson = preg_replace('/^```(?:json)?\s*|\s*```$/i', '', trim($response));
                $parsed = json_decode($cleanJson, true);

                if (is_array($parsed) && isset($parsed['score'], $parsed['intent'], $parsed['suggested_reply'])) {
                    $inquiry->update([
                        'lead_score' => max(0, min(100, (int) $parsed['score'])),
                        'lead_intent' => strtolower((string) $parsed['intent']),
                        'ai_summary' => (string) ($parsed['summary'] ?? 'Commercial inquiry evaluated by AI.'),
                        'ai_suggested_reply' => (string) $parsed['suggested_reply'],
                        'ai_analyzed_at' => now(),
                    ]);

                    return $inquiry->fresh();
                }
            }
        } catch (\Throwable $e) {
            Log::info("LeadScoringService: AI scoring failed for inquiry #{$inquiry->id}: " . $e->getMessage());
        }

        // Deterministic Fallback Scoring Engine
        return self::deterministicScore($inquiry);
    }

    /**
     * Deterministic rule-based fallback scoring when AI is unreachable
     */
    protected static function deterministicScore(Inquiry $inquiry): Inquiry
    {
        $score = 50;
        $text = strtolower(($inquiry->message ?? '') . ' ' . ($inquiry->service_interest ?? '') . ' ' . ($inquiry->company ?? ''));

        // 1. Budget checks
        $budget = strtolower($inquiry->budget ?? '');
        if (str_contains($budget, '5,000') || str_contains($budget, '10,000') || str_contains($budget, 'enterprise')) {
            $score += 30;
        } elseif (str_contains($budget, '3,000') || str_contains($budget, '2,500') || str_contains($budget, '1,000')) {
            $score += 18;
        }

        // 2. High-value tech keywords
        $highValueKeywords = ['laravel', 'next.js', 'react', 'custom', 'saas', 'api', 'ecommerce', 'mobile app', 'flutter', 'redesign', 'audit', 'ranking', 'seo'];
        foreach ($highValueKeywords as $kw) {
            if (str_contains($text, $kw)) {
                $score += 5;
            }
        }

        // 3. Corporate domain check
        $email = strtolower($inquiry->email ?? '');
        $freeMailDomains = ['@gmail.', '@yahoo.', '@hotmail.', '@outlook.', '@live.', '@icloud.'];
        $isFreeMail = false;
        foreach ($freeMailDomains as $fd) {
            if (str_contains($email, $fd)) {
                $isFreeMail = true;
                break;
            }
        }
        if (!$isFreeMail && !empty($email)) {
            $score += 10;
        }

        // 4. Spam detection
        if (str_contains($text, 'casino') || str_contains($text, 'crypto') || str_contains($text, 'backlink package') || strlen($inquiry->message ?? '') < 10) {
            $score -= 35;
        }

        $score = max(10, min(95, $score));

        $intent = match (true) {
            $score >= 80 => 'enterprise',
            $score >= 65 => 'hot',
            $score >= 40 => 'warm',
            default => 'cold',
        };

        $clientFirstName = explode(' ', trim($inquiry->name ?? 'there'))[0] ?: 'there';
        $service = $inquiry->service_interest ?: 'Web & Growth Engineering';

        $draftReply = "Hi {$clientFirstName},\n\nThank you for reaching out to WebRanker! We reviewed your inquiry regarding {$service}.\n\nOur engineering team specializes in high-performance Laravel architectures, Next.js systems, and technical SEO designed for organic Google dominance.\n\nWe would love to discuss your scope in detail. Are you available for a brief 15-minute consultation this week? You can also reach our leadership team directly on WhatsApp at +91 97185 70218.\n\nBest regards,\nWebRanker Strategy Team";

        $inquiry->update([
            'lead_score' => $score,
            'lead_intent' => $intent,
            'ai_summary' => "Inbound inquiry for {$service}. Commercial intent analyzed with score {$score}/100.",
            'ai_suggested_reply' => $draftReply,
            'ai_analyzed_at' => now(),
        ]);

        return $inquiry->fresh();
    }
}
