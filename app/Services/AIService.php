<?php

namespace App\Services;

use App\Models\AIConversation;
use App\Models\AIMessage;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    /**
     * WebRanker Agency Grounded Knowledge Base (Dynamic RAG Prompt & Expert Guidelines)
     */
    public static function getSystemPrompt(?string $ragContext = null): string
    {
        $siteName = config('site.name', 'WebRanker');
        $siteEmail = config('site.email', 'info@webranker.in');
        $sitePhone = config('site.phone', '+91 97185 70218');
        $whatsappUrl = 'https://wa.me/919718570218?text=Hi%20WebRanker%20Team%2C%20I%20would%20like%20to%20discuss%20a%20project%20and%20get%20service%20details.';

        $retrievedKnowledge = $ragContext ?: RAGService::retrieveContext('')['formatted_context'];

        return <<<PROMPT
You are an expert Web Development and SEO consultant for {$siteName}, a professional software engineering and digital growth agency.

=== 0. MANDATORY BREVITY & CHATBOT CONCISENESS RULE (CRITICAL) ===
• STRICT LENGTH LIMIT: Keep EVERY response SHORT, CRISP, AND SNAPPY (strictly between 60 to 110 words total).
• NEVER write long essays, detailed delivery phases (DO NOT output "Phase 1", "Phase 2", etc.), or long lists of 6+ items. Users find long text boring on chat and mobile screens!
• STRICT 3-PART STRUCTURE FOR EVERY RESPONSE:
  1. Direct Answer: 1 or 2 clear, punchy sentences answering the user directly.
  2. Core Highlights: STRICT MAXIMUM OF 2 TO 3 concise bullet points (`•`).
  3. Actionable Close: 1 short sentence inviting them for their Name & Email or proposing a consultation.
• BE DIRECT, FAST TO READ, AND PROFESSIONAL.

=== 1. WEB DEVELOPMENT SERVICES ===
We develop modern, scalable, secure, and SEO-friendly websites and web applications using technologies such as:
• Python / FastAPI (High-performance asynchronous APIs, AI/ML backends, microservices)
• Node.js / Express (JavaScript/TypeScript backends, real-time WebSockets, REST/GraphQL APIs)
• Laravel / PHP (Enterprise web applications, robust MVC architecture, admin portals, custom APIs)
• WordPress (CMS-driven marketing websites, blogs, corporate portals, easy content management)
• React.js (Interactive, component-driven client-side user interfaces, SPAs, rich web apps)
• Next.js (Modern React applications with SSR/SSG, sub-second Core Web Vitals, and optimal search indexing)
• Databases: MySQL, PostgreSQL, Redis (caching/sessions), MongoDB
• REST APIs, GraphQL, and Third-Party API integrations
• Payment Gateway integrations (Stripe, Razorpay, PayPal, etc.)

TECHNOLOGY SELECTION GUIDELINE:
When a user asks which technology should be used, NEVER blindly recommend one technology or declare one universally superior. First understand their project requirements, scale, and budget, then explain which technology fits the use case and why:
• Laravel → suitable for custom business applications, robust APIs, admin systems, and database-heavy portals.
• FastAPI → suitable for high-performance Python APIs, AI/ML services, and backend APIs.
• Node.js → suitable for JavaScript/TypeScript backend applications, APIs, and real-time event-driven apps.
• WordPress → suitable for CMS-driven websites, blogs, business websites, and non-technical content management.
• React.js → suitable for interactive, dynamic frontend applications and client portals.
• Next.js → suitable for modern React applications where SSR/SSG, sub-second performance, and SEO crawlability are important.

=== 2. THIRD-PARTY APIS & INTEGRATION QUESTIONS ===
If a user asks: "Can you integrate payment gateways and third-party APIs?"
Confirm that YES, we integrate APIs and external services depending on the project requirements. Examples include:
• Payment gateways (Stripe, Razorpay, PayPal, Apple Pay, Google Pay)
• CRM & ERP APIs (HubSpot, Salesforce, Zoho, custom ERPs)
• Email and SMS APIs (SendGrid, Twilio, AWS SES)
• Google APIs & location services (Google Maps, Places, Geocoding)
• Social media APIs (Meta, LinkedIn, YouTube, TikTok)
• Shipping and logistics APIs (Shiprocket, FedEx, DHL)
• Accounting APIs (QuickBooks, Xero, Stripe Billing)
• Authentication APIs (OAuth 2.0, Google/Apple SSO, JWT)
• AI & LLM APIs (OpenAI, Claude, Groq, custom vector search)
• Custom REST APIs & Webhooks with HMAC signature verification
Explain that the exact integration depends on the third-party provider, API documentation, authentication method, business requirements, and security requirements. Do not claim an integration is supported unless it fits standard web standards.

=== 3. SEO-FRIENDLY WEBSITE DEVELOPMENT ===
Whenever users ask for a website, explain that modern websites should be built SEO-friendly from the ground up:
• Mobile responsive (mobile-first design)
• Fast loading & optimized for Core Web Vitals (sub-second LCP, zero CLS, low INP)
• User-friendly and accessible (WCAG guidelines)
• Secure (HTTPS, SSL, sanitized inputs)
• Search-engine crawlable with semantic HTML5 headings (H1-H4)
• Optimized for images (modern WebP/AVIF, lazy loading) and metadata (OpenGraph, Schema.org JSON-LD)
• Clean, descriptive URL structure
• Properly configured with XML sitemap and robots.txt
Always explain SEO as an integral part of the development process, not merely an afterthought.

=== 4. SEO SERVICES ===
When users ask about SEO, explain relevant areas:
• Technical SEO: Crawl budget optimization, server TTFB, schema markup, XML sitemaps, robots.txt, canonical URLs, redirect mapping.
• On-Page SEO: Keyword research, content optimization, meta titles and descriptions, heading structure, internal linking.
• Page Speed & Core Web Vitals: Mobile SEO, image optimization, CSS/JS minification, caching.
• Setup & Analytics: Google Search Console setup, Google Analytics 4 integration, local SEO, and authoritative off-page SEO.
CRITICAL RANKING RULE: NEVER guarantee a #1 Google ranking or a specific ranking position. Explain that Google's algorithm evaluates 200+ factors, and we implement proven, white-hat technical, architectural, and content strategies engineered for continuous organic compounding.

=== 5. COMMON PROJECT TYPES (E-COMMERCE & REDESIGNS) ===
• E-Commerce Website Inquiries: Explain key features including product management, categories, faceted search/filters, shopping cart, checkout, payment gateway integration, order management, customer accounts, email notifications, admin dashboard, SEO optimization, mobile responsive UI, and third-party shipping/CRM integrations.
• Website Redesign Inquiries: Explain that redesigns include modern UI/UX, full mobile responsiveness, improved navigation, faster page speed, SEO retention (301 redirects), accessibility improvements, conversion-focused layouts, and API/backend modernization.

=== 6. SECURITY & DATA INTEGRITY ===
For payment, API, and user-data related questions, highlight appropriate security practices:
• Mandatory HTTPS and SSL encryption
• Secure API authentication (OAuth 2.0, API keys, signed tokens)
• Strict input validation and server-side validation
• Secure database queries with prepared statements (preventing SQL injection)
• Rate limiting and CSRF protection
• Secure webhook verification (secret signing)
• Proper error handling (no stack traces in production)
• Sensitive credentials strictly stored in environment variables (never exposed in source code)

=== 7. STRICT BUSINESS & PRICING RULES ===
• DO NOT quote specific dollar or rupee prices, packages, or costs in chat.
• When a user asks about cost or pricing (e.g., e-commerce, custom CRM, headless store, SEO packages):
  - NEVER list 10+ factors or 7 delivery phases! Keep it strictly under 100 words.
  - Explain in 1 sentence that custom cost depends on technical architecture, design complexity, and third-party integrations.
  - Provide ONLY 2 TO 3 short bullet points (`•`) covering key cost drivers (e.g., frontend tech, APIs/gateways, catalog scale).
  - Conclude by asking for their Name and Email address so our leadership can prepare an exact scope and quote.
• Direct leadership channels:
  • WhatsApp: {$sitePhone} ({$whatsappUrl})
  • Email: {$siteEmail}
  • Direct Call: {$sitePhone}
• Keep technical explanations concise, punchy, and scannable for busy clients.
• Match the user's language naturally (English or Hindi/Hinglish).
• STRICTLY NO HTML TAGS (no `<br>`, `<b>`, etc.). Standard markdown double asterisks `**` and newlines only.
• STRICTLY NO MARKDOWN TABLES (pipe tables break the chat window). Use clean bullet lists (`•`).
• STRICTLY NO VERSION NUMBERS: NEVER output version numbers for languages, frameworks, or tools.
• STRICT OUT-OF-DOMAIN REFUSAL: Politely decline off-topic queries (food, tourism, weather, politics).

=== 8. PROACTIVE & NATURAL LEAD CAPTURE (CLIENT NAME & EMAIL) ===
• When a client demonstrates project interest (e.g. asking to build a website, redesign, e-commerce, custom CRM, SaaS product, booking system, employee portal, mobile app, SEO ranking/audit, PPC ads, or asking about pricing/packages/process):
  1. Provide a direct, short answer (1-2 sentences).
  2. Give 2 to 3 concise bullet points (`•`).
  3. If Name/Email not yet provided, close with:
     • English: "To help our engineering leadership prepare a customized technical scope and quote, could you please share your **Name** and **Email address**?"
     • Hindi / Hinglish: "Aapke project ke liye customized technical roadmap aur exact proposal share karne ke liye, kya aap apna **Name** aur **Email address** share kar sakte hain?"
• Once the client shares contact info, thank them warmly and confirm receipt.

=== VERIFIED SITE KNOWLEDGE (RAG CONTEXT) ===
{$retrievedKnowledge}
PROMPT;
    }

    /**
     * Generate an intelligent reply using RAG pipeline + Free AI Provider (Groq / Gemini)
     * with graceful local fallback if no API key is configured.
     */
    public static function generateReply(string $userMessage, array $conversationHistory = [], ?string $sessionId = null, ?string $clientIp = null, ?string $country = null): array
    {
        $conversation = null;
        $leadCaptured = false;

        $clientIp = $clientIp ?: \App\Services\GeoIPService::getClientIp();
        $country = $country ?: \App\Services\GeoIPService::getCountry($clientIp);

        // 1. Manage Conversation Session & Lead Auto-Detection in MySQL
        if (!empty($sessionId)) {
            try {
                $conversation = AIConversation::firstOrCreate(
                    ['session_id' => $sessionId],
                    [
                        'created_at' => now(),
                        'ip_address' => $clientIp,
                        'country' => $country,
                    ]
                );

                if (empty($conversation->ip_address) && !empty($clientIp)) {
                    $conversation->ip_address = $clientIp;
                }
                if (empty($conversation->country) && !empty($country)) {
                    $conversation->country = $country;
                }

                // Auto-detect Name, email & phone if visitor typed them into the chat
                $detected = self::detectAndCaptureLead($userMessage, $conversation, $clientIp, $country);
                if ($detected) {
                    $leadCaptured = true;
                }

                // Record user message
                AIMessage::create([
                    'conversation_id' => $conversation->id,
                    'role' => 'user',
                    'content' => $userMessage,
                ]);

                // If visitor just provided their contact details, warmly acknowledge immediately
                if ($detected && (strlen($userMessage) < 90 || preg_match('/^(my name|mera naam|contact me|my email|call me|i am|here is my)/i', trim($userMessage)))) {
                    $clientName = $conversation->lead_name ?: 'there';
                    $contactDetail = $conversation->lead_email ?: ($conversation->lead_phone ?: 'contact details');
                    $leadReply = "Thank you, **{$clientName}**! We have successfully recorded your details ({$contactDetail}). Our senior technology leadership will review your requirements and reach out directly with a customized technical scope and roadmap.\n\nIn the meantime, feel free to share any specific features, design preferences, or target timelines you have in mind!";

                    self::saveAssistantMessage($conversation, $leadReply);

                    return [
                        'reply' => $leadReply,
                        'provider' => 'webranker-lead-engine',
                        'quick_replies' => [
                            ['label' => 'Chat on WhatsApp', 'action' => 'whatsapp'],
                            ['label' => 'Schedule Consultation', 'action' => 'consult'],
                            ['label' => 'Our Core Services', 'action' => 'message'],
                        ],
                        'lead_captured' => true,
                        'session_id' => $sessionId,
                    ];
                }
            } catch (\Throwable $e) {
                Log::warning('AI conversation logging failed: ' . $e->getMessage());
            }
        }

        // 2. GUARDRAIL 1: Vague or nonsensical query
        if (RAGService::isVagueOrInvalid($userMessage)) {
            $reply = RAGService::getInvalidQueryResponse($userMessage);
            self::saveAssistantMessage($conversation, $reply);

            return [
                'reply' => $reply,
                'provider' => 'webranker-guardrail',
                'quick_replies' => self::generateQuickReplies($userMessage),
                'lead_captured' => $leadCaptured,
                'session_id' => $sessionId,
            ];
        }

        // 3. GUARDRAIL 2: Strictly block out-of-domain queries (food in Jaipur, tourism, weather, etc.)
        if (RAGService::isOffTopic($userMessage)) {
            $reply = RAGService::getOffTopicRefusal($userMessage);
            self::saveAssistantMessage($conversation, $reply);

            return [
                'reply' => $reply,
                'provider' => 'webranker-guardrail',
                'quick_replies' => [
                    ['label' => 'Our Core Services', 'action' => 'message'],
                    ['label' => 'Custom Web Development', 'action' => 'message'],
                    ['label' => 'SEO & Keyword Ranking', 'action' => 'message'],
                    ['label' => 'Chat on WhatsApp', 'action' => 'whatsapp'],
                    ['label' => 'Schedule Consultation', 'action' => 'consult'],
                ],
                'lead_captured' => $leadCaptured,
                'session_id' => $sessionId,
            ];
        }

        // 4. RAG KNOWLEDGE RETRIEVAL from MySQL Database
        $ragResult = RAGService::retrieveContext($userMessage);
        $ragContext = $ragResult['formatted_context'];

        $groqKey = config('services.groq.key') ?: env('GROQ_API_KEY');
        $geminiKey = config('services.gemini.key') ?: env('GEMINI_API_KEY');
        $provider = env('AI_PROVIDER', 'groq');

        $reply = null;
        $activeProvider = 'webranker-expert-engine';

        // 5. Try Groq Cloud (100% Free Tier) with Grounded RAG Prompt
        if ($provider === 'groq' && !empty($groqKey)) {
            try {
                $messages = [
                    ['role' => 'system', 'content' => self::getSystemPrompt($ragContext)]
                ];

                $trimmedHistory = array_slice($conversationHistory, -6);
                foreach ($trimmedHistory as $msg) {
                    if (!empty($msg['role']) && !empty($msg['text'])) {
                        $role = ($msg['role'] === 'bot' || $msg['role'] === 'assistant') ? 'assistant' : 'user';
                        $messages[] = ['role' => $role, 'content' => $msg['text']];
                    }
                }
                $messages[] = ['role' => 'user', 'content' => $userMessage];

                $groqReply = GroqAIService::chat($messages, null, 0.55, 250);
                if (!empty($groqReply)) {
                    $reply = $groqReply;
                    $activeProvider = 'groq-rag-ai';
                }
            } catch (\Throwable $e) {
                Log::warning('Groq AI API error, trying fallback: ' . $e->getMessage());
            }
        }

        // 6. Try Google Gemini (Free Tier - Gemini 1.5 Flash) with RAG
        if (empty($reply) && !empty($geminiKey)) {
            try {
                $geminiReply = self::callGemini($userMessage, $conversationHistory, $geminiKey, $ragContext);
                if (!empty($geminiReply)) {
                    $reply = $geminiReply;
                    $activeProvider = 'gemini-rag-ai';
                }
            } catch (\Throwable $e) {
                Log::warning('Gemini AI API error, using local expert engine: ' . $e->getMessage());
            }
        }

        // 4. Fallback: Local Expert Engine (Ensures 100% uptime with zero keys required)
        if (empty($reply)) {
            $reply = self::generateLocalExpertReply($userMessage);
            $activeProvider = 'webranker-expert-engine';
        }

        // Clean any accidental HTML tags from LLM response (<br> to newlines, remove tags)
        if (!empty($reply)) {
            $reply = preg_replace('/<br\s*\/?>/i', "\n", $reply);
            $reply = strip_tags($reply);
            $reply = RAGService::stripVersionNumbers($reply);
        }

        // 5. Store bot reply in conversation history
        if ($conversation) {
            try {
                AIMessage::create([
                    'conversation_id' => $conversation->id,
                    'role' => 'assistant',
                    'content' => $reply,
                ]);
            } catch (\Throwable $e) {
                Log::warning('Failed saving AI assistant message: ' . $e->getMessage());
            }
        }

        return [
            'reply' => $reply,
            'provider' => $activeProvider,
            'quick_replies' => self::generateQuickReplies($userMessage),
            'lead_captured' => $leadCaptured,
            'session_id' => $sessionId,
        ];
    }

    /**
     * Save assistant reply to database
     */
    protected static function saveAssistantMessage(?AIConversation $conversation, string $reply): void
    {
        if ($conversation) {
            try {
                AIMessage::create([
                    'conversation_id' => $conversation->id,
                    'role' => 'assistant',
                    'content' => $reply,
                ]);
            } catch (\Throwable $e) {
                Log::warning('Failed saving AI assistant message: ' . $e->getMessage());
            }
        }
    }

    /**
     * Auto-detect Name, Email and Phone from user message and record/sync lead in MySQL
     */
    public static function detectAndCaptureLead(string $message, AIConversation $conversation, ?string $clientIp = null, ?string $country = null): bool
    {
        $hasLead = false;

        // 1. Detect Email
        if (preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $message, $emailMatches)) {
            $email = trim($emailMatches[0]);
            $conversation->lead_email = $email;
            $hasLead = true;
        }

        // 2. Detect Phone (10+ digits)
        if (preg_match('/(?:\+?[0-9]{1,3}[-.\s]?)?(?:\(?\d{2,4}\)?[-.\s]?)?\d{3,4}[-.\s]?\d{4,6}/', $message, $phoneMatches)) {
            $rawDigits = preg_replace('/[^0-9]/', '', $phoneMatches[0]);
            if (strlen($rawDigits) >= 10 && strlen($rawDigits) <= 15) {
                $conversation->lead_phone = trim($phoneMatches[0]);
                $hasLead = true;
            }
        }

        // 3. Detect Name
        $detectedName = null;
        // Patterns: "My name is John Doe", "I am John Doe", "Mera naam Rahul hai", "Name: Alex Smith"
        if (preg_match('/(?:my name is|i am|i\'m|this is|mera naam|naam|name\s*[:\-])\s+([A-Za-z\s]{2,40})/i', $message, $nameMatches)) {
            $candidate = trim(preg_replace('/^(hai|here|is)\s*/i', '', trim($nameMatches[1])));
            $candidate = preg_replace('/\s+(hai|hoon|here|please|and|my|email|phone|contact).*$/i', '', $candidate);
            if (strlen($candidate) >= 2 && strlen($candidate) <= 40) {
                $detectedName = ucwords(strtolower($candidate));
            }
        }

        // Check if message has email and begins with a 2-word name before comma or email
        if (!$detectedName && !empty($conversation->lead_email)) {
            $parts = explode($conversation->lead_email, $message);
            $beforeEmail = trim($parts[0] ?? '');
            $beforeEmail = trim($beforeEmail, " ,:-\t\n\r");
            if (preg_match('/(?:^|[\n\r])([A-Z][a-z]{1,20}\s+[A-Z][a-z]{1,20})\b/u', $beforeEmail, $nMatches)) {
                $words = explode(' ', trim($nMatches[1]));
                $ignored = ['hello', 'team', 'webranker', 'project', 'want', 'need', 'please', 'thanks', 'contact'];
                if (!in_array(strtolower($words[0]), $ignored)) {
                    $detectedName = ucwords(strtolower(trim($nMatches[1])));
                }
            }
        }

        if ($detectedName) {
            $conversation->lead_name = $detectedName;
            $hasLead = true;
        }

        if (!empty($clientIp)) {
            $conversation->ip_address = $clientIp;
        }
        if (!empty($country)) {
            $conversation->country = $country;
        }

        if ($hasLead) {
            $conversation->save();

            $effectiveIp = $conversation->ip_address ?: ($clientIp ?: \App\Services\GeoIPService::getClientIp());
            $effectiveCountry = $conversation->country ?: ($country ?: \App\Services\GeoIPService::getCountry($effectiveIp));

            // Find existing inquiry linked to this conversation, session, or email
            $inquiry = Inquiry::where('conversation_id', $conversation->id)->first();
            if (!$inquiry && !empty($conversation->session_id)) {
                $inquiry = Inquiry::where('session_id', $conversation->session_id)->first();
            }
            if (!$inquiry && !empty($conversation->lead_email)) {
                $inquiry = Inquiry::where('email', $conversation->lead_email)->first();
            }

            $serviceInterest = self::inferServiceInterest($message, $conversation);
            $clientDisplayName = $conversation->lead_name ?: ($inquiry?->name ?: 'AI Chat Prospect');

            $inquiryData = [
                'name' => $clientDisplayName,
                'email' => $conversation->lead_email ?: ($inquiry?->email ?: 'lead-' . substr($conversation->session_id, 0, 8) . '@webranker.in'),
                'phone' => $conversation->lead_phone ?: ($inquiry?->phone ?? null),
                'company' => $inquiry?->company ?: 'Captured via AI Chatbot',
                'service_interest' => $serviceInterest,
                'budget' => $inquiry?->budget ?: 'Discussed via AI Chat',
                'message' => 'Prospect engaged with WebRanker AI Assistant. Latest message: ' . substr($message, 0, 300),
                'source_url' => url()->current(),
                'ip_address' => $effectiveIp,
                'country' => $effectiveCountry,
                'conversation_id' => $conversation->id,
                'session_id' => $conversation->session_id,
            ];

            if ($inquiry) {
                $inquiry->update(array_filter($inquiryData, fn($v) => !is_null($v)));
            } else {
                $inquiryData['status'] = 'new';
                $inquiry = Inquiry::create($inquiryData);
            }
        }

        return $hasLead;
    }

    /**
     * Infer the primary service category from user message & conversation
     */
    public static function inferServiceInterest(string $message, ?AIConversation $conversation = null): string
    {
        $text = strtolower($message);
        if ($conversation) {
            try {
                $past = $conversation->messages()->where('role', 'user')->pluck('content')->implode(' ');
                $text .= ' ' . strtolower($past);
            } catch (\Throwable $e) {}
        }

        if (str_contains($text, 'e-commerce') || str_contains($text, 'ecommerce') || str_contains($text, 'shop') || str_contains($text, 'store') || str_contains($text, 'cart')) {
            return 'E-Commerce Web Application';
        }
        if (str_contains($text, 'crm')) {
            return 'Custom Enterprise CRM';
        }
        if (str_contains($text, 'saas')) {
            return 'SaaS Product Architecture';
        }
        if (str_contains($text, 'booking') || str_contains($text, 'reservation')) {
            return 'Custom Booking Portal';
        }
        if (str_contains($text, 'employee') || str_contains($text, 'hrm') || str_contains($text, 'management system')) {
            return 'Custom Management Software';
        }
        if (str_contains($text, 'redesign') || str_contains($text, 'revamp') || str_contains($text, 'modernize') || str_contains($text, 'outdated')) {
            return 'Website Redesign & Modernization';
        }
        if (str_contains($text, 'seo') || str_contains($text, 'rank') || str_contains($text, 'organic') || str_contains($text, 'google rank')) {
            return 'Technical SEO & Keyword Ranking';
        }
        if (str_contains($text, 'ppc') || str_contains($text, 'google ads') || str_contains($text, 'adwords') || str_contains($text, 'campaign')) {
            return 'PPC & Google Ads Marketing';
        }
        if (str_contains($text, 'app') || str_contains($text, 'mobile') || str_contains($text, 'ios') || str_contains($text, 'android') || str_contains($text, 'flutter')) {
            return 'Mobile App Engineering';
        }
        if (str_contains($text, 'ai') || str_contains($text, 'chatbot') || str_contains($text, 'automate') || str_contains($text, 'assistant')) {
            return 'AI Solutions & Chatbot Automation';
        }
        if (str_contains($text, 'api') || str_contains($text, 'payment') || str_contains($text, 'stripe') || str_contains($text, 'gateway')) {
            return 'API & Payment Gateway Integration';
        }
        if (str_contains($text, 'speed') || str_contains($text, 'wordpress') || str_contains($text, 'core web vitals')) {
            return 'Performance & Speed Optimization';
        }

        return 'Custom Web Development';
    }

    /**
     * Call Google Gemini 1.5 Flash API (Free Tier)
     */
    protected static function callGemini(string $userMessage, array $history, string $apiKey, ?string $ragContext = null): ?string
    {
        $contents = [];

        $trimmedHistory = array_slice($history, -6);
        foreach ($trimmedHistory as $msg) {
            if (!empty($msg['role']) && !empty($msg['text'])) {
                $role = ($msg['role'] === 'bot' || $msg['role'] === 'assistant') ? 'model' : 'user';
                $contents[] = [
                    'role' => $role,
                    'parts' => [['text' => $msg['text']]]
                ];
            }
        }

        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $userMessage]]
        ];

        $response = Http::timeout(12)->post(
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $apiKey,
            [
                'system_instruction' => [
                    'parts' => [['text' => self::getSystemPrompt($ragContext)]]
                ],
                'contents' => $contents,
                'generationConfig' => [
                    'temperature' => 0.6,
                    'maxOutputTokens' => 250,
                ],
            ]
        );

        if ($response->successful()) {
            $data = $response->json();
            return $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
        }

        Log::error('Gemini API Error Response: ' . $response->body());
        return null;
    }

    /**
     * Built-in Expert Engine (Smart responses without requiring any API key)
     */
    public static function generateLocalExpertReply(string $input): string
    {
        // Guardrails for Local Engine
        if (RAGService::isVagueOrInvalid($input)) {
            return RAGService::getInvalidQueryResponse($input);
        }

        if (RAGService::isOffTopic($input)) {
            return RAGService::getOffTopicRefusal($input);
        }

        $lower = strtolower(trim($input));
        $sitePhone = config('site.phone', '+91 97185 70218');
        $siteEmail = config('site.email', 'info@webranker.in');
        $whatsappUrl = 'https://wa.me/919718570218?text=Hi%20WebRanker%20Team%2C%20I%20would%20like%20to%20discuss%20project%20pricing%20and%20scope.';

        // 1. Inquiries about Pricing, Cost, Budget, Packages, Quotes
        if (preg_match('/(price|cost|quote|budget|rate|package|fee|pricing|charges|how much|kitna charge|kitne ka)/i', $lower)) {
            $ask = str_contains($lower, 'kitna') || str_contains($lower, 'batao') || str_contains($lower, 'hoga')
                ? "\n\nAapke project requirements ke mutabiq exact architecture roadmap aur customized proposal ke liye, kya aap apna **Name** aur **Email address** share kar sakte hain?"
                : "\n\nTo help our engineering leadership prepare a customized architecture scope and proposal for you, could you please share your **Name** and **Email address**?";

            return "At **WebRanker**, every project and marketing campaign is custom-scoped to match your exact business goals, architecture, and competitive landscape. We do not use rigid, one-size-fits-all pricing packages.\n\nTo get a customized proposal and transparent scope for your project, please connect with our leadership team directly:\n\n• **WhatsApp Direct:** {$sitePhone}\n• **Official Email:** {$siteEmail}\n• **Phone:** {$sitePhone}\n\nOr click **Schedule Consultation** below to book a complimentary strategy session with our Principal Engineer!" . $ask;
        }

        // 2. Custom CRM / SaaS / Employee Management / Booking System
        if (preg_match('/(crm|saas|booking|portal|employee|dashboard|login|signup|excel|software)/i', $lower)) {
            $isHinglish = str_contains($lower, 'banwana') || str_contains($lower, 'chahiye') || str_contains($lower, 'hai') || str_contains($lower, 'kya');
            $ask = $isHinglish
                ? "\n\nAapke custom system ke liye exact technical architecture aur module breakdown share karne ke liye, kya aap apna **Name** aur **Email address** share kar sakte hain?"
                : "\n\nTo help our engineering leadership prepare a customized architecture roadmap and module breakdown for your application, could you please share your **Name** and **Email address**?";

            return "Yes, our engineering team specializes in architecting custom enterprise CRMs, SaaS products, client portals, and workflow automation systems:\n\n• **Backend Architecture:** Laravel, Node.js, or Python/FastAPI with clean modular domain services.\n• **High-Performance Frontend:** Next.js or React.js with role-based access control (RBAC), multi-tenancy, and intuitive dashboards.\n• **Data Migration & Integration:** Seamless transition from Excel/legacy software to normalized PostgreSQL/MySQL databases.\n• **Key Modules:** Secure authentication, client/order tracking, automated email/WhatsApp alerts, and real-time reporting.\n• **REST & Third-Party APIs:** Integration with payment gateways, communication APIs, and external ERPs.\n\nShare your core workflow requirements, and our team will outline the ideal data structure and technical roadmap!" . $ask;
        }

        // 3. Third-Party APIs, Payment Gateways & External Integrations
        if (preg_match('/(api|apis|payment gateway|stripe|razorpay|paypal|third party|third-party|webhook|webhooks|integration|integrations)/i', $lower)) {
            return "Yes. We can integrate payment gateways and third-party APIs based on your project's requirements. Our development team works with technologies such as Laravel, Python/FastAPI, Node.js and modern JavaScript frameworks.\n\nCommon integrations include:\n\n• **Payment Gateways:** Stripe, Razorpay, PayPal, Apple Pay, Google Pay\n• **CRM & ERP APIs:** HubSpot, Salesforce, Zoho, custom ERPs\n• **Email & SMS Services:** SendGrid, Twilio, AWS SES\n• **Google & Maps APIs:** Google Maps, Places, Geocoding\n• **Shipping APIs:** Shiprocket, FedEx, DHL\n• **Authentication Services:** OAuth 2.0, Google/Apple SSO, JWT\n• **AI APIs:** OpenAI, Anthropic Claude, custom LLMs\n• **Custom REST APIs & Webhooks:** with secure HMAC signature verification\n\nWe also build secure, mobile-friendly, and SEO-friendly websites around these integrations. The exact integration depends on the API provider and your business requirements.\n\nTo help our technical team prepare the API integration architecture for your project, could you please share your **Name** and **Email address**?";
        }

        // 4. Technology Selection & Stack Advice
        if (preg_match('/(which technology|tech stack|fastapi|node|laravel vs|react vs next|what tech|choose tech|recommend tech|stack)/i', $lower)) {
            return "Choosing the right technology depends on your project goals, scalability needs, and feature set. We analyze your requirements before recommending a stack:\n\n• **Laravel:** Suitable for custom business applications, APIs, admin systems, and database-heavy portals.\n• **FastAPI:** Suitable for high-performance Python APIs, AI/ML services, and fast backend APIs.\n• **Node.js:** Suitable for JavaScript/TypeScript backend applications, APIs, and real-time event-driven apps.\n• **WordPress:** Suitable for CMS-driven websites, blogs, business websites, and non-technical content management.\n• **React.js:** Suitable for interactive, dynamic frontend applications and single-page apps (SPAs).\n• **Next.js:** Suitable for modern React applications where SSR/SSG, performance, and SEO are important.\n\nShare your project idea and requirements, and our team will recommend the ideal architecture for your timeline and scale!\n\nCould you please share your **Name** and **Email address** so our principal engineer can send you an architecture roadmap?";
        }

        // 5. Fast & SEO-Friendly Website / WordPress Speed
        if (preg_match('/(fast|seo-friendly|seo website|speed|core web vitals|fast loading|lighthouse|slow)/i', $lower)) {
            return "We can build a fast, mobile-friendly and SEO-focused website using technologies such as Next.js, Laravel, FastAPI, Node.js or WordPress depending on your requirements:\n\n• **Responsive Mobile-First Design:** Flawless usability across all screen sizes.\n• **Fast Page Loading:** Core Web Vitals optimization (sub-second LCP, zero CLS).\n• **SEO-Friendly URLs:** Clean, crawlable hierarchical URLs.\n• **Metadata & Headings:** Semantic HTML headings (H1-H4) and optimized meta titles/descriptions.\n• **Schema Markup:** Schema.org JSON-LD structured data for rich snippets.\n• **XML Sitemap & Robots.txt:** Automated generation and crawl configuration.\n• **Image Optimization:** Modern WebP/AVIF formats with responsive srcset.\n• **Secure HTTPS Setup:** Complete SSL configuration and analytics/Search Console integration.\n\nFor WordPress speed optimization, we audit slow database queries, implement Redis/server caching, optimize asset bundles, and eliminate bloat.\n\nCould you share your **Name**, **Email address**, and current website URL so we can perform a free speed analysis?";
        }

        // 6. E-Commerce Solutions
        if (preg_match('/(ecommerce|e-commerce|shop|store|sell online|products|cart|checkout)/i', $lower)) {
            return "We build custom, high-converting E-Commerce platforms engineered for speed, reliability, and sales:\n\n• **Product & Inventory Management:** Categories, variants, SKU tracking, and inventory sync.\n• **Search & Filters:** High-speed faceted search and attribute filtering.\n• **Cart & Checkout:** Frictionless multi-step or one-page checkout supporting multiple payment gateways.\n• **Payment Gateways:** Integration with Stripe, Razorpay, PayPal, Apple Pay, and digital wallets.\n• **Order Management:** Automated invoices, order lifecycle tracking, and customer account portals.\n• **Admin Dashboard:** Real-time analytics, revenue reporting, and promotion/coupon management.\n• **SEO & Core Web Vitals:** Rich Schema Product markup and sub-second page rendering for higher search visibility.\n\nTo help our team prepare a customized E-Commerce scope and feature checklist, could you please share your **Name** and **Email address**?";
        }

        // 7. Website Redesign & Modernization
        if (preg_match('/(redesign|revamp|rebuild|modernize|update website|purani)/i', $lower)) {
            return "Our website redesign services modernize your brand presence while preserving and growing your organic search traffic:\n\n• **Modern UI/UX:** Clean, intuitive layouts built for high conversion and brand trust.\n• **Mobile Responsiveness:** Mobile-first architecture tested across all screen resolutions.\n• **SEO Equity Preservation:** Complete 301 redirect mapping to protect existing Google rankings.\n• **Page Speed Acceleration:** Code modernization and Core Web Vitals optimization.\n• **Accessibility Improvements:** WCAG-compliant design patterns.\n• **API & Backend Integration:** Modernizing legacy databases and connecting current business tools.\n\nCould you share your **Name**, **Email address**, and existing website link so our principal architect can prepare a complimentary revamp assessment?";
        }

        // 8. Comprehensive SEO Services
        if (preg_match('/(seo|rank|ranking|google|organic|traffic|backlink|keyword|serp)/i', $lower)) {
            return "**WebRanker Comprehensive SEO Services:**\n\nWe engineer sustainable organic search visibility through technical precision and topical authority:\n\n• **Technical SEO:** Crawl budget optimization, server TTFB, schema markup, XML sitemaps, robots.txt, and canonical URLs.\n• **On-Page SEO:** In-depth keyword research, content optimization, heading structure, and meta titles/descriptions.\n• **Page Speed & Core Web Vitals:** Mobile SEO, image optimization, CSS/JS minification, and caching.\n• **Analytics & Reporting:** Google Search Console setup, Google Analytics 4 integration, and regular performance reporting.\n\n*Note: We never guarantee a #1 Google ranking as search algorithms evaluate hundreds of factors, but we apply proven, white-hat frameworks engineered for continuous organic growth.*\n\nCould you please share your **Name**, **Email address**, and website URL so our SEO specialists can run a complimentary keyword gap analysis?";
        }

        // 9. PPC / Paid Advertising
        if (preg_match('/(ppc|ads|adwords|google ads|meta ads|campaign)/i', $lower)) {
            return "**WebRanker PPC & Performance Marketing:**\n\nWe design and manage high-ROI paid search and social campaigns engineered for qualified lead generation:\n\n• **High-Intent Search Ads:** Google Search campaigns targeting decision-maker search queries.\n• **Conversion Landing Pages:** Custom high-speed landing pages with friction-free lead capture forms.\n• **Conversion Tracking:** Server-side tracking via Google Tag Manager and GA4 for 100% data fidelity.\n• **Negative Keyword Management & A/B Testing:** Continuous bid optimization and budget efficiency.\n\nCould you please share your **Name** and **Email address** so our marketing strategist can outline a tailored campaign plan?";
        }

        // 10. Custom Web Development & Architecture
        if (preg_match('/(web|development|website|next|react|laravel|php|fastapi|python|node|code|banwani)/i', $lower)) {
            $isHinglish = str_contains($lower, 'banwani') || str_contains($lower, 'kar sakte') || str_contains($lower, 'chahiye');
            $ask = $isHinglish
                ? "\n\nAapke project ke liye customized technical roadmap aur architecture scope share karne ke liye, kya aap apna **Name** aur **Email address** share kar sakte hain?"
                : "\n\nTo help our engineering leadership prepare a customized architecture roadmap and proposal for your business, could you please share your **Name** and **Email address**?";

            return "**WebRanker Custom Web Development:**\n\nWe engineer bespoke, high-performance web applications tailored to your exact business workflow:\n\n• **Full-Stack Engineering:** Python/FastAPI, Node.js, and Laravel on the backend paired with React.js or Next.js on the frontend.\n• **Sub-Second Performance:** Server-side rendering (SSR), edge caching, and zero-blocking JavaScript.\n• **Scalable Architectures:** High-concurrency database design (PostgreSQL/MySQL), Redis caching, and robust queuing.\n• **Custom Solutions:** Enterprise SaaS platforms, client portals, marketplace systems, and bespoke REST APIs.\n\nAre you planning a new platform from scratch or upgrading an existing system?" . $ask;
        }

        // 11. Mobile App Engineering
        if (preg_match('/(mobile|app|flutter|ios|android|react native)/i', $lower)) {
            return "**WebRanker Mobile App Engineering:**\n\nWe engineer beautiful, high-performance native and cross-platform mobile apps:\n\n• **Technologies:** Flutter, React Native, iOS (Swift), and Android (Kotlin).\n• **Enterprise Capabilities:** Real-time offline synchronization, sub-100ms API response latency, and biometric security.\n• **End-to-End Delivery:** From bespoke Figma UI design to App Store and Google Play deployment.\n\nCould you please share your **Name** and **Email address** so our mobile tech lead can share a technical scope for your app?";
        }

        // 12. Free Audit & Performance Scans
        if (preg_match('/(audit|free audit|analysis|review|score|cwv|lighthouse|diagnos)/i', $lower)) {
            return "We provide a complimentary **48-Hour Technical SEO & Core Web Vitals Audit** for businesses.\n\nOur senior engineers evaluate:\n• Real-world LCP, INP, and CLS performance benchmarks\n• Server TTFB and JavaScript hydration bottlenecks\n• Untapped high-converting topical ranking clusters\n• Meta title, schema markup, and crawl efficiency gaps\n\nCould you please share your **Name**, **Email address**, and website URL so we can prepare your free audit report?";
        }

        // 13. Contact & Direct Reach
        if (preg_match('/(contact|talk|hire|call|meet|consult|schedule|speak|whatsapp|email|phone)/i', $lower)) {
            return "You can connect directly with our leadership team:\n\n• **WhatsApp Direct:** {$sitePhone}\n• **Email:** {$siteEmail}\n• **Direct Phone:** {$sitePhone}\n\nOr simply reply here with your **Name** and **Email address**, and our senior architect will contact you within 24 hours!";
        }

        // Default Intelligent Greeting & Overview
        return "Thank you for reaching out to **WebRanker**! We are a professional software engineering and SEO consulting agency specializing in:\n\n• **High-Performance Web Development** (Laravel, Python/FastAPI, Node.js, Next.js, React)\n• **Custom CRMs, SaaS & Enterprise Applications**\n• **Third-Party APIs & Payment Gateway Integrations**\n• **Technical & On-Page SEO Services**\n• **E-Commerce & Website Redesigns**\n• **Mobile App Engineering** (Flutter, iOS, Android)\n\nTo help our technical leadership understand your requirements and share a tailored roadmap, could you share your **Name**, **Email address**, and what project you are planning?";
    }

    /**
     * Generate dynamic contextual follow-up suggestion chips
     */
    public static function generateQuickReplies(string $userMessage): array
    {
        $lower = strtolower($userMessage);

        if (str_contains($lower, 'ppc') || str_contains($lower, 'ad')) {
            return [
                ['label' => 'Google Ads Strategy', 'action' => 'message'],
                ['label' => 'Chat on WhatsApp', 'action' => 'whatsapp'],
                ['label' => 'Schedule Consultation', 'action' => 'consult'],
                ['label' => 'Claim Free Audit', 'action' => 'audit'],
            ];
        }

        if (str_contains($lower, 'audit') || str_contains($lower, 'seo') || str_contains($lower, 'rank')) {
            return [
                ['label' => 'Claim Free Audit', 'action' => 'audit'],
                ['label' => 'Technical SEO Details', 'action' => 'message'],
                ['label' => 'Chat on WhatsApp', 'action' => 'whatsapp'],
                ['label' => 'Schedule Consultation', 'action' => 'consult'],
            ];
        }

        if (str_contains($lower, 'price') || str_contains($lower, 'cost') || str_contains($lower, 'quote')) {
            return [
                ['label' => 'Chat on WhatsApp', 'action' => 'whatsapp'],
                ['label' => 'Schedule Consultation', 'action' => 'consult'],
                ['label' => 'Our Core Services', 'action' => 'message'],
            ];
        }

        if (str_contains($lower, 'api') || str_contains($lower, 'payment') || str_contains($lower, 'integration') || str_contains($lower, 'gateway')) {
            return [
                ['label' => 'Payment Gateway Details', 'action' => 'message'],
                ['label' => 'Tech Stack Selection', 'action' => 'message'],
                ['label' => 'Chat on WhatsApp', 'action' => 'whatsapp'],
                ['label' => 'Schedule Consultation', 'action' => 'consult'],
            ];
        }

        if (str_contains($lower, 'ecommerce') || str_contains($lower, 'shop') || str_contains($lower, 'store')) {
            return [
                ['label' => 'E-Commerce Solutions', 'action' => 'message'],
                ['label' => 'APIs & Payment Gateways', 'action' => 'message'],
                ['label' => 'Chat on WhatsApp', 'action' => 'whatsapp'],
                ['label' => 'Schedule Consultation', 'action' => 'consult'],
            ];
        }

        if (str_contains($lower, 'redesign') || str_contains($lower, 'revamp') || str_contains($lower, 'modernize')) {
            return [
                ['label' => 'Website Redesign Scope', 'action' => 'message'],
                ['label' => 'Claim Free Audit', 'action' => 'audit'],
                ['label' => 'Chat on WhatsApp', 'action' => 'whatsapp'],
                ['label' => 'Schedule Consultation', 'action' => 'consult'],
            ];
        }

        if (str_contains($lower, 'next') || str_contains($lower, 'laravel') || str_contains($lower, 'web') || str_contains($lower, 'fastapi') || str_contains($lower, 'node')) {
            return [
                ['label' => 'Tech Stack Selection', 'action' => 'message'],
                ['label' => 'APIs & Payment Gateways', 'action' => 'message'],
                ['label' => 'Technical SEO & Speed', 'action' => 'message'],
                ['label' => 'Chat on WhatsApp', 'action' => 'whatsapp'],
                ['label' => 'Schedule Consultation', 'action' => 'consult'],
            ];
        }

        return [
            ['label' => 'Tech Stack Advice', 'action' => 'message'],
            ['label' => 'APIs & Payment Gateways', 'action' => 'message'],
            ['label' => 'Fast SEO-Friendly Website', 'action' => 'message'],
            ['label' => 'E-Commerce Solutions', 'action' => 'message'],
            ['label' => 'Website Redesign', 'action' => 'message'],
            ['label' => 'Chat on WhatsApp', 'action' => 'whatsapp'],
            ['label' => 'Schedule Consultation', 'action' => 'consult'],
        ];
    }

    /**
     * Retrieve conversation history for a given session
     */
    public static function getHistory(string $sessionId): array
    {
        $conversation = AIConversation::where('session_id', $sessionId)
            ->with(['messages' => function ($q) {
                $q->orderBy('id', 'asc');
            }])
            ->first();

        if (!$conversation) {
            return [];
        }

        return $conversation->messages->map(function ($msg) {
            return [
                'role' => $msg->role === 'assistant' ? 'bot' : 'user',
                'text' => $msg->content,
                'created_at' => $msg->created_at?->toIso8601String(),
            ];
        })->toArray();
    }
}
