<?php

namespace App\Services;

use App\Models\Faq;
use App\Models\IndustryDomain;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Log;

class RAGService
{
    /**
     * Stopwords in English & Hinglish to filter out during keyword extraction
     */
    protected const STOPWORDS = [
        'a', 'about', 'above', 'after', 'again', 'against', 'all', 'am', 'an', 'and', 'any', 'are', 'as', 'at',
        'be', 'because', 'been', 'before', 'being', 'below', 'between', 'both', 'but', 'by', 'could', 'did',
        'do', 'does', 'doing', 'down', 'during', 'each', 'few', 'for', 'from', 'further', 'had', 'has', 'have',
        'having', 'he', 'her', 'here', 'hers', 'herself', 'him', 'himself', 'his', 'how', 'i', 'if', 'in',
        'into', 'is', 'it', 'its', 'itself', 'me', 'more', 'most', 'my', 'myself', 'no', 'nor', 'not', 'of',
        'off', 'on', 'once', 'only', 'or', 'other', 'ought', 'our', 'ours', 'ourselves', 'out', 'over', 'own',
        'same', 'she', 'should', 'so', 'some', 'such', 'than', 'that', 'the', 'their', 'theirs', 'them',
        'themselves', 'then', 'there', 'these', 'they', 'this', 'those', 'through', 'to', 'too', 'under',
        'until', 'up', 'very', 'was', 'we', 'were', 'what', 'when', 'where', 'which', 'while', 'who', 'whom',
        'why', 'with', 'would', 'you', 'your', 'yours', 'yourself', 'yourselves',
        // Hindi / Hinglish common stop words
        'hai', 'hain', 'ho', 'hote', 'hota', 'hoti', 'kya', 'kyu', 'kyun', 'kaise', 'kaha', 'kahan', 'kab',
        'ka', 'ke', 'ki', 'ko', 'se', 'me', 'mein', 'par', 'pe', 'aur', 'ya', 'bhi', 'to', 'toh', 'ye', 'yeh',
        'wo', 'woh', 'apna', 'apne', 'apni', 'mera', 'mere', 'meri', 'kuch', 'koi', 'sab', 'sabse', 'batao',
        'bataye', 'batayein', 'bataiye', 'chahiye', 'karo', 'kare', 'karna', 'krna', 'skta', 'sakta', 'krte'
    ];

    /**
     * Obvious off-topic keywords (food, tourism, weather, entertainment, non-WebRanker trivia)
     */
    protected const OFF_TOPIC_PATTERNS = [
        // Food / Dining / Restaurants / Cafes
        '/\b(khana|khane|khao|khaye|food|foods|dish|dishes|restaurant|restaurants|hotel|hotels|lunch|dinner|breakfast|nashta|recipe|recipes|swiggy|zomato|cafe|cafes|mithai|kachori|samosa|dal baati|biryani|paneer|sweet|sweets|roti|chai|tea|coffee|street food|tasty)\b/i',
        // Tourism / Travel / Sightseeing / Visiting
        '/\b(ghoomne|ghumne|ghumna|ghoomna|darshan|visit|visiting|tourism|tourist|tourists|sightseeing|places to visit|monument|monuments|fort|forts|palace|palaces|hawa mahal|jal mahal|amer fort|nahargarh|train|trains|flight|flights|ticket|tickets|travel|trip|holiday|holidays|resort|resorts)\b/i',
        // Weather / Climate
        '/\b(mausam|weather|temperature|baarish|barish|rain|rainfall|climate|forecast)\b/i',
        // Entertainment / Sports / Bollywood / General Trivia
        '/\b(movie|movies|film|films|cinema|theatre|actor|actress|bollywood|hollywood|cricket|ipl|match|score|song|songs|gaana|music|dance|shayari|joke|jokes|comedy|game|games)\b/i',
        // Politics / Non-business news
        '/\b(politics|narendra modi|rahul gandhi|election|voting|party|minister|bjp|congress|pm modi)\b/i',
        // School homework / Academic trivia
        '/\b(physics|chemistry|biology|homework|essay on|algebra|derivative|integral|geometry)\b/i',
        // Personal / Relationship questions
        '/\b(girlfriend|boyfriend|shaadi|marriage|dating|love advice|pyaar|dost)\b/i',
    ];

    /**
     * Valid business domain keywords for WebRanker
     */
    protected const DOMAIN_PATTERNS = [
        '/\b(web|website|web development|frontend|backend|fullstack|php|laravel|react|reactjs|next|nextjs|node|nodejs|python|fastapi|html|css|javascript|vue|angular|wordpress|shopify|magento|ecommerce|e-commerce|store|cart|checkout)\b/i',
        '/\b(seo|ranking|rank|google|serp|organic|keyword|keywords|backlink|backlinks|search engine|crawl|indexing|lighthouse|core web vitals|pagespeed|traffic|schema|sitemap|robots\.txt|meta|heading|canonical)\b/i',
        '/\b(ppc|pay per click|ads|google ads|meta ads|facebook ads|instagram ads|adwords|campaign|roas|roi|paid search|advertising|sem|lead generation|leads)\b/i',
        '/\b(app|mobile app|android|ios|flutter|react native|swift|kotlin|cross-platform|play store|app store)\b/i',
        '/\b(software|custom software|saas|portal|crm|erp|api|apis|rest api|rest apis|webhook|webhooks|payment gateway|stripe|razorpay|paypal|third-party|integration|integrations|database|postgres|postgresql|mysql|redis|cloud|devops|aws|docker)\b/i',
        '/\b(ai|automation|agent|bot|chatbot|llm|workflow|machine learning)\b/i',
        '/\b(ui|ux|design|figma|branding|logo|wireframe|redesign|speed|optimization|maintenance|support|retainer|security|https|ssl|authentication|oauth)\b/i',
        '/\b(webranker|agency|company|team|services|service|portfolio|project|audit|free audit|consultation|schedule|quote|pricing|price|cost|contact|hire|talk|whatsapp|email|phone|address|office)\b/i',
        '/\b(healthcare|real estate|fintech|finance|education|edtech|logistics|travel tech|saas|retail|hospital|clinic)\b/i',
    ];

    /**
     * Check if a query is clearly off-topic
     */
    public static function isOffTopic(string $query): bool
    {
        $query = strtolower(trim($query));

        // If it matches any off-topic pattern
        foreach (self::OFF_TOPIC_PATTERNS as $pattern) {
            if (preg_match($pattern, $query)) {
                // If it ALSO has an explicit technical/agency keyword (e.g. "restaurant website banwani hai" or "food delivery app/api"), it is ON-TOPIC!
                if (preg_match('/\b(website|web|app|application|software|seo|ranking|design|portal|develop|build|banwana|banwani|banwao|system|api|apis|payment|gateway|integration|integrations|redesign)\b/i', $query)) {
                    return false;
                }
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if query is vague / nonsensical / low-intent
     */
    public static function isVagueOrInvalid(string $query): bool
    {
        $trimmed = trim($query);

        // Less than 2 characters
        if (mb_strlen($trimmed) < 2) {
            return true;
        }

        // Only symbols or punctuation
        if (preg_match('/^[^a-zA-Z0-9\x{0900}-\x{097F}]+$/u', $trimmed)) {
            return true;
        }

        // Repetitive single character (e.g. "aaaaa", "?????", ".....")
        if (preg_match('/^(.)\1{4,}$/u', $trimmed)) {
            return true;
        }

        return false;
    }

    /**
     * Generate an appropriate polite refusal for off-topic inquiries
     */
    public static function getOffTopicRefusal(string $query): string
    {
        $sitePhone = config('site.phone', '+91 97185 70218');
        $siteEmail = config('site.email', 'info@webranker.in');

        // Check if query is primarily in Hindi/Hinglish
        $isHindi = preg_match('/[\x{0900}-\x{097F}]/u', $query) ||
            preg_match('/\b(kya|hai|batao|kaha|kaise|me|mein|par|aur|chahiye|khana|ghumne)\b/i', $query);

        if ($isHindi) {
            return "Main **WebRanker** ka AI Tech & Growth Assistant hoon. Main sirf hamari agency ki digital engineering aur organic search services ke bare me jankari de sakta hoon:\n\n" .
                "• **High-Performance Web Development** (Laravel, Next.js, React)\n" .
                "• **Technical SEO & Page #1 Google Ranking**\n" .
                "• **PPC & Paid Search Performance Marketing** (Google Ads & Meta Ads)\n" .
                "• **Mobile App Engineering** (Flutter, iOS, Android)\n" .
                "• **AI Automation & Intelligent Workflows**\n\n" .
                "Khane, ghoomne ya kisi anya general topic par main jankari nahi de sakta. Agar aapko apni website banwani hai, mobile app develop karna hai ya business grow karna hai, to batayein aap kis project par baat karna chahte hain?";
        }

        return "I am the **WebRanker AI Tech & Growth Strategist**. I specialize exclusively in WebRanker's digital engineering and organic search services:\n\n" .
            "• **High-Performance Web Development** (Laravel, Next.js, React)\n" .
            "• **Technical SEO & Page #1 Google Ranking Dominance**\n" .
            "• **PPC & Paid Search Performance Marketing** (Google Ads, Meta Ads)\n" .
            "• **Mobile App Engineering** (Flutter, iOS, Android)\n" .
            "• **AI Automation & Intelligent Workflows**\n\n" .
            "I cannot assist with food recommendations, tourism, or unrelated topics. If you are planning a high-impact web or mobile project, or want to dominate Google search rankings, how can our engineering team assist you today?";
    }

    /**
     * Generate helpful guidance for vague or invalid inquiries
     */
    public static function getInvalidQueryResponse(string $query): string
    {
        return "Aapka sawal poori tarah clear nahi hai. Main **WebRanker** ka AI consultant hoon aur aapki in vishayon me madad kar sakta hoon:\n\n" .
            "• **Custom Web Development:** Nayi high-speed website ya enterprise web app banwane ke liye (Laravel, Next.js, React).\n" .
            "• **Technical SEO & Ranking:** Google ke pehle page par rank karne aur organic traffic badhane ke liye.\n" .
            "• **PPC & Performance Ads:** Google Ads aur Meta Ads se verified ROI leads generate karne ke liye.\n" .
            "• **Mobile App Development:** Cross-platform Flutter ya Native Android/iOS apps ke liye.\n" .
            "• **Claim Free Audit:** Apni existing website ka 48-Hour Technical & SEO Audit bilkul free paane ke liye.\n\n" .
            "Aap apne project ya requirement ke bare me batayein — aapko kis service ki zaroorat hai?";
    }

    /**
     * RAG Engine: Retrieve the most relevant site entities (Services, FAQs, Industries, Settings)
     * grounded in the user's specific query.
     */
    public static function retrieveContext(string $query): array
    {
        $tokens = self::tokenize($query);
        $retrieved = [
            'services' => [],
            'faqs' => [],
            'industries' => [],
            'site_profile' => self::getSiteProfile(),
            'formatted_context' => '',
        ];

        if (empty($tokens)) {
            $retrieved['formatted_context'] = self::formatDefaultContext();
            return $retrieved;
        }

        // 1. Search Services table
        try {
            $services = Service::active()->get();
            $scoredServices = [];

            foreach ($services as $service) {
                $score = self::calculateRelevanceScore(
                    $tokens,
                    $service->title . ' ' .
                    $service->category . ' ' .
                    $service->short_description . ' ' .
                    $service->focus_keywords . ' ' .
                    json_encode($service->technologies ?? []) . ' ' .
                    json_encode($service->features ?? [])
                );

                if ($score > 0) {
                    $scoredServices[] = [
                        'score' => $score,
                        'service' => $service,
                    ];
                }
            }

            usort($scoredServices, fn($a, $b) => $b['score'] <=> $a['score']);
            $retrieved['services'] = array_slice(array_column($scoredServices, 'service'), 0, 3);
        } catch (\Throwable $e) {
            Log::warning('RAG Service query failed: ' . $e->getMessage());
        }

        // 2. Search FAQs
        try {
            $faqs = Faq::active()->get();
            $scoredFaqs = [];

            foreach ($faqs as $faq) {
                $score = self::calculateRelevanceScore(
                    $tokens,
                    $faq->question . ' ' . $faq->answer . ' ' . $faq->category
                );

                if ($score > 0) {
                    $scoredFaqs[] = [
                        'score' => $score,
                        'faq' => $faq,
                    ];
                }
            }

            usort($scoredFaqs, fn($a, $b) => $b['score'] <=> $a['score']);
            $retrieved['faqs'] = array_slice(array_column($scoredFaqs, 'faq'), 0, 2);
        } catch (\Throwable $e) {
            Log::warning('RAG FAQ query failed: ' . $e->getMessage());
        }

        // 3. Search Industry Domains
        try {
            $industries = IndustryDomain::active()->get();
            $scoredIndustries = [];

            foreach ($industries as $industry) {
                $score = self::calculateRelevanceScore(
                    $tokens,
                    $industry->name . ' ' .
                    $industry->description . ' ' .
                    $industry->category_group . ' ' .
                    json_encode($industry->tags ?? [])
                );

                if ($score > 0) {
                    $scoredIndustries[] = [
                        'score' => $score,
                        'industry' => $industry,
                    ];
                }
            }

            usort($scoredIndustries, fn($a, $b) => $b['score'] <=> $a['score']);
            $retrieved['industries'] = array_slice(array_column($scoredIndustries, 'industry'), 0, 2);
        } catch (\Throwable $e) {
            Log::warning('RAG IndustryDomain query failed: ' . $e->getMessage());
        }

        // 4. Format into structured markdown context for LLM prompt injection
        $retrieved['formatted_context'] = self::formatRetrievedContext($retrieved);

        return $retrieved;
    }

    /**
     * Format retrieved context into LLM inject-ready text
     */
    protected static function formatRetrievedContext(array $retrieved): string
    {
        $out = "=== VERIFIED WEBRANKER KNOWLEDGE BASE (GROUNDED RAG DATA) ===\n";
        $profile = $retrieved['site_profile'];

        $out .= "COMPANY: {$profile['name']}\n";
        $out .= "HEADQUARTERS: {$profile['address']}\n";
        $out .= "PHONE / WHATSAPP: {$profile['phone']}\n";
        $out .= "OFFICIAL EMAIL: {$profile['email']}\n";
        $out .= "CORE OFFER: 48-Hour Free Technical SEO & Core Web Vitals Audit, Custom Architecture Scoping.\n\n";

        if (!empty($retrieved['services'])) {
            $out .= "RELEVANT WEBRANKER SERVICES MATCHED FROM DATABASE:\n";
            foreach ($retrieved['services'] as $svc) {
                $out .= "• [Service: {$svc->title}] (Category: {$svc->category})\n";
                if (!empty($svc->short_description)) {
                    $out .= "  Summary: " . rtrim($svc->short_description, '.') . ".\n";
                }
                if (!empty($svc->technologies)) {
                    $techList = is_array($svc->technologies) ? implode(', ', $svc->technologies) : (string)$svc->technologies;
                    $out .= "  Tech Stack: {$techList}\n";
                }
                if (!empty($svc->features) && is_array($svc->features)) {
                    $featuresPreview = array_slice($svc->features, 0, 4);
                    $featureNames = array_map(function ($f) {
                        return is_array($f) ? ($f['title'] ?? ($f['name'] ?? '')) : (string)$f;
                    }, $featuresPreview);
                    $out .= "  Key Capabilities: " . implode(' | ', array_filter($featureNames)) . "\n";
                }
                if (!empty($svc->kpi_label) && !empty($svc->kpi_value)) {
                    $out .= "  Benchmark KPI: {$svc->kpi_label}: {$svc->kpi_value}\n";
                }
                $out .= "\n";
            }
        }

        if (!empty($retrieved['faqs'])) {
            $out .= "RELEVANT VERIFIED FAQS MATCHED FROM DATABASE:\n";
            foreach ($retrieved['faqs'] as $faq) {
                $out .= "Q: {$faq->question}\n";
                $out .= "A: {$faq->answer}\n\n";
            }
        }

        if (!empty($retrieved['industries'])) {
            $out .= "RELEVANT INDUSTRY DOMAIN EXPERTISE MATCHED:\n";
            foreach ($retrieved['industries'] as $ind) {
                $out .= "• [Industry: {$ind->name}] ({$ind->category_group})\n";
                if (!empty($ind->description)) {
                    $out .= "  Specialization: {$ind->description}\n";
                }
                if (!empty($ind->highlight_stat) && !empty($ind->stat_label)) {
                    $out .= "  Proven Impact: {$ind->highlight_stat} {$ind->stat_label}\n";
                }
                $out .= "\n";
            }
        }

        $out .= "=== END OF VERIFIED RAG DATA ===\n";

        return self::stripVersionNumbers($out);
    }

    /**
     * Strip technology version numbers (e.g., PHP 8.3, Laravel 11/12, Next.js 15, React 19)
     */
    public static function stripVersionNumbers(string $text): string
    {
        // Remove version numbers in parentheses like "(PHP 8.3)" or "(PHP)"
        $text = preg_replace('/\((?:PHP|Python|Laravel|Next\.?js|React|Node\.?js)\s*[\d\.]*\)/i', '', $text);
        // Replace "PHP 8.3", "Laravel 11", "Laravel 12", "Next.js 15", "React 19", "Flutter 3" with clean names
        $text = preg_replace('/\b(PHP|Laravel|Next\.?js|React|Python|Node\.?js|Flutter|Vue)\s+v?[\d\.]+\b/i', '$1', $text);
        // Clean multiple spaces
        $text = preg_replace('/[ \t]{2,}/', ' ', $text);

        return trim($text);
    }

    /**
     * Default summary context when query does not match a single specific service
     */
    protected static function formatDefaultContext(): string
    {
        $profile = self::getSiteProfile();

        return <<<TEXT
=== VERIFIED WEBRANKER AGENCY BASELINE (GROUNDED RAG DATA) ===
COMPANY: {$profile['name']}
HEADQUARTERS: {$profile['address']}
PHONE / WHATSAPP: {$profile['phone']}
EMAIL: {$profile['email']}
CORE SERVICES:
1. High-Performance Web Development (Laravel, Next.js, React, Headless architectures)
2. Technical SEO & Organic Ranking (Schema graphs, sub-second TTFB, topical clusters)
3. PPC & Paid Search Performance Marketing (Google Ads, Meta Ads, high-converting CRO funnels)
4. Mobile App Engineering (Flutter, iOS, Android, sub-100ms offline sync)
5. AI Automation & Intelligent Workflows (Custom business agents, LLM integrations)
6. UI/UX Design Systems (Figma design tokens, chamfered design language)
GUARANTEE: Sub-second load times, Core Web Vitals optimization, custom scoping with direct engineer access.
PRICING POLICY: Custom proposals only. Strictly no package prices in chat. Direct all prospects to WhatsApp or Email.
=== END OF VERIFIED RAG DATA ===
TEXT;
    }

    /**
     * Load WebRanker core profile from DB settings
     */
    public static function getSiteProfile(): array
    {
        $address = 'Plot no. 51, Shaheed Amit Bhardwaj Marg, Sector 8, Malviya Nagar, Jaipur, Rajasthan 302017';
        $phone = config('site.phone', '+91 97185 70218');
        $email = config('site.email', 'info@webranker.in');
        $name = config('site.name', 'WebRanker');

        try {
            $localBusiness = SiteSetting::where('key', 'schema_local_business')->value('value');
            if ($localBusiness) {
                $decoded = json_decode($localBusiness, true);
                if (!empty($decoded['telephone'])) {
                    $phone = $decoded['telephone'];
                }
                if (!empty($decoded['email'])) {
                    $email = $decoded['email'];
                }
                if (!empty($decoded['street_address'])) {
                    $address = $decoded['street_address'] . ', ' . ($decoded['address_locality'] ?? 'Jaipur') . ', ' . ($decoded['postal_code'] ?? '302017');
                }
            }
        } catch (\Throwable $e) {
            // fallback
        }

        return [
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
        ];
    }

    /**
     * Tokenize query into meaningful search keywords
     */
    protected static function tokenize(string $text): array
    {
        // Lowercase and remove punctuation
        $cleaned = preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', mb_strtolower($text));
        $words = preg_split('/\s+/', $cleaned, -1, PREG_SPLIT_NO_EMPTY);

        $tokens = [];
        foreach ($words as $word) {
            if (mb_strlen($word) > 2 && !in_array($word, self::STOPWORDS, true)) {
                $tokens[] = $word;
            }
        }

        return array_values(array_unique($tokens));
    }

    /**
     * Relevance scoring calculation
     */
    protected static function calculateRelevanceScore(array $tokens, string $targetText): int
    {
        $targetLower = mb_strtolower($targetText);
        $score = 0;

        foreach ($tokens as $token) {
            if (str_contains($targetLower, $token)) {
                $score += 10;
                // Extra points for whole word match
                if (preg_match('/\b' . preg_quote($token, '/') . '\b/u', $targetLower)) {
                    $score += 15;
                }
            }
        }

        return $score;
    }
}
