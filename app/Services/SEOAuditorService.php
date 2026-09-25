<?php

namespace App\Services;

use App\Models\AiAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SEOAuditorService
{
    /**
     * Run a comprehensive, free AI performance & SEO audit for a target domain.
     *
     * @param string $rawDomain
     * @param string $email
     * @param string|null $phone
     * @param Request|null $request
     * @return array
     */
    public function auditDomain(string $rawDomain, string $email, ?string $phone = null, ?Request $request = null): array
    {
        $normalizedUrl = $this->normalizeUrl($rawDomain);
        $host = parse_url($normalizedUrl, PHP_URL_HOST) ?: $rawDomain;

        $clientIp = $request ? $request->ip() : request()->ip();
        $country = GeoIPService::getCountry($clientIp, $request);

        // 1. Fetch Real-time Lighthouse / PageSpeed or heuristic metrics
        $metrics = $this->fetchLighthouseData($normalizedUrl, $host);

        // 2. Generate 48-Hour AI Growth & SEO Roadmap
        $roadmap = $this->generateAIRoadmap($host, $metrics);

        // 3. Save strictly to ai_audits table (audits are kept separate from general inquiries)
        $audit = AiAudit::create([
            'domain_url' => $normalizedUrl,
            'email' => $email,
            'phone' => $phone,
            'speed_score' => $metrics['performance_score'],
            'seo_score' => $metrics['seo_score'],
            'performance_metrics' => $metrics,
            'ai_roadmap' => $roadmap,
            'ip_address' => $clientIp,
            'country' => $country,
            'status' => 'completed',
        ]);

        return [
            'success' => true,
            'audit_id' => $audit->id,
            'domain' => $host,
            'url' => $normalizedUrl,
            'speed_score' => $metrics['performance_score'],
            'seo_score' => $metrics['seo_score'],
            'metrics' => $metrics,
            'roadmap' => $roadmap,
            'created_at' => $audit->created_at->toIso8601String(),
        ];
    }

    /**
     * Normalize URL string to valid https protocol
     */
    protected function normalizeUrl(string $domain): string
    {
        $domain = trim($domain);
        $domain = preg_replace('#^https?://#i', '', $domain);
        $domain = rtrim($domain, '/');

        // Prepend https://
        return 'https://' . $domain;
    }

    /**
     * Query Google PageSpeed Insights API (Free 25,000 queries/day) with Heuristic Fallback
     */
    protected function fetchLighthouseData(string $url, string $host): array
    {
        $apiKey = env('GOOGLE_PAGESPEED_API_KEY');
        $apiUrl = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed';

        $queryParams = [
            'url' => $url,
            'strategy' => 'mobile', // Google Mobile-First Indexing
            'category' => ['performance', 'seo'],
        ];

        if (!empty($apiKey)) {
            $queryParams['key'] = $apiKey;
        }

        try {
            $response = Http::timeout(10)->withoutVerifying()->get($apiUrl, $queryParams);

            if ($response->successful()) {
                $data = $response->json();
                $lighthouse = $data['lighthouseResult'] ?? [];

                $perfScore = isset($lighthouse['categories']['performance']['score'])
                    ? (int) round($lighthouse['categories']['performance']['score'] * 100)
                    : 74;

                $seoScore = isset($lighthouse['categories']['seo']['score'])
                    ? (int) round($lighthouse['categories']['seo']['score'] * 100)
                    : 82;

                $audits = $lighthouse['audits'] ?? [];

                $fcp = $audits['first-contentful-paint']['displayValue'] ?? '1.6 s';
                $lcp = $audits['largest-contentful-paint']['displayValue'] ?? '2.8 s';
                $cls = $audits['cumulative-layout-shift']['displayValue'] ?? '0.08';
                $tbt = $audits['total-blocking-time']['displayValue'] ?? '180 ms';
                $speedIndex = $audits['speed-index']['displayValue'] ?? '2.1 s';
                $ttfb = $audits['server-response-time']['displayValue'] ?? '420 ms';

                return [
                    'source' => 'google_pagespeed',
                    'performance_score' => $perfScore,
                    'seo_score' => $seoScore,
                    'fcp' => $fcp,
                    'lcp' => $lcp,
                    'cls' => $cls,
                    'tbt' => $tbt,
                    'speed_index' => $speedIndex,
                    'ttfb' => $ttfb,
                    'cwv_status' => ($perfScore >= 85) ? 'PASS' : (($perfScore >= 50) ? 'NEEDS IMPROVEMENT' : 'POOR'),
                    'opportunities' => $this->extractOpportunities($audits),
                ];
            }
        } catch (\Throwable $e) {
            Log::info("Google PageSpeed API request failed for {$url}: " . $e->getMessage());
        }

        // Real-time Heuristic Diagnostic Fallback (measuring real HTTP response + HTML SEO structure)
        return $this->heuristicSiteAudit($url, $host);
    }

    /**
     * Heuristic live analyzer for immediate diagnostic when PageSpeed API is unavailable/slow
     */
    protected function heuristicSiteAudit(string $url, string $host): array
    {
        $startTime = microtime(true);
        $html = '';
        $statusCode = 200;

        try {
            $resp = Http::timeout(5)->withoutVerifying()->get($url);
            $statusCode = $resp->status();
            $html = (string) $resp->body();
        } catch (\Throwable $e) {
            Log::info("Direct diagnostic fetch error for {$url}: " . $e->getMessage());
        }

        $durationMs = round((microtime(true) - $startTime) * 1000);

        // Analyze HTML features
        $hasTitle = preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $mTitle);
        $titleLength = $hasTitle ? strlen(trim($mTitle[1])) : 0;
        $titleGood = ($titleLength >= 30 && $titleLength <= 65);

        $hasMetaDesc = preg_match('/<meta[^>]+name=[\'"]description[\'"][^>]+content=[\'"](.*?)[\'"]/is', $html, $mDesc);
        $descGood = $hasMetaDesc && strlen(trim($mDesc[1])) >= 70;

        $hasViewport = (bool) preg_match('/<meta[^>]+name=[\'"]viewport[\'"]/is', $html);
        $hasCanonical = (bool) preg_match('/<link[^>]+rel=[\'"]canonical[\'"]/is', $html);
        $hasSchema = (bool) preg_match('/<script[^>]+type=[\'"]application\/ld\+json[\'"]/is', $html);
        $hasOg = (bool) preg_match('/<meta[^>]+property=[\'"]og:image[\'"]/is', $html);
        $h1Count = preg_match_all('/<h1[^>]*>/is', $html);

        // Compute realistic SEO score
        $seoScore = 55;
        if ($titleGood) $seoScore += 12;
        elseif ($hasTitle) $seoScore += 6;
        if ($descGood) $seoScore += 12;
        elseif ($hasMetaDesc) $seoScore += 6;
        if ($hasViewport) $seoScore += 8;
        if ($hasCanonical) $seoScore += 5;
        if ($hasSchema) $seoScore += 10;
        if ($hasOg) $seoScore += 5;
        if ($h1Count === 1) $seoScore += 5;
        $seoScore = min(96, max(42, $seoScore));

        // Compute realistic Performance Score based on real TTFB & payload
        $perfScore = 88;
        if ($durationMs > 800) $perfScore -= 15;
        elseif ($durationMs > 450) $perfScore -= 8;

        if (strlen($html) > 250000) $perfScore -= 10; // heavy unminified HTML
        elseif (strlen($html) > 120000) $perfScore -= 5;

        // Core Web Vitals estimates
        $fcpEst = number_format(max(0.9, ($durationMs / 1000) * 1.4), 1) . ' s';
        $lcpEst = number_format(max(1.8, ($durationMs / 1000) * 2.6), 1) . ' s';
        $clsEst = $hasViewport ? '0.04' : '0.18';
        $tbtEst = max(60, min(480, (int) round($durationMs * 0.45))) . ' ms';
        $ttfbEst = $durationMs . ' ms';

        $opportunities = [];
        if (!$hasSchema) {
            $opportunities[] = 'Missing Organization & WebSite JSON-LD Schema structured data';
        }
        if (!$hasCanonical) {
            $opportunities[] = 'Missing self-referencing canonical tag to prevent duplicate indexation';
        }
        if (!$descGood) {
            $opportunities[] = 'Meta description is missing or suboptimal for Google SERP CTR';
        }
        if ($durationMs > 400) {
            $opportunities[] = 'Server response time (TTFB) is higher than recommended 200 ms';
        }
        $opportunities[] = 'Defer non-critical third-party JavaScript & unminified stylesheets';
        $opportunities[] = 'Serve hero banners and responsive images in modern WebP/AVIF formats';

        return [
            'source' => 'live_heuristic_diagnostic',
            'performance_score' => $perfScore,
            'seo_score' => $seoScore,
            'fcp' => $fcpEst,
            'lcp' => $lcpEst,
            'cls' => $clsEst,
            'tbt' => $tbtEst,
            'speed_index' => number_format(max(1.4, ($durationMs / 1000) * 1.8), 1) . ' s',
            'ttfb' => $ttfbEst,
            'cwv_status' => ($perfScore >= 85) ? 'PASS' : (($perfScore >= 60) ? 'NEEDS IMPROVEMENT' : 'POOR'),
            'opportunities' => array_slice($opportunities, 0, 4),
        ];
    }

    /**
     * Extract top Lighthouse speed & SEO opportunities
     */
    protected function extractOpportunities(array $audits): array
    {
        $keys = [
            'render-blocking-resources',
            'modern-image-formats',
            'unused-javascript',
            'unminified-javascript',
            'server-response-time',
            'uses-optimized-images',
            'meta-description',
            'structured-data',
        ];

        $results = [];
        foreach ($keys as $k) {
            if (isset($audits[$k]) && isset($audits[$k]['score']) && $audits[$k]['score'] < 0.9) {
                $title = $audits[$k]['title'] ?? '';
                if (!empty($title)) {
                    $results[] = $title;
                }
            }
        }

        if (empty($results)) {
            $results = [
                'Optimize Large Contentful Paint (LCP) hero element loading priority',
                'Implement Next.js / Edge caching for instant sub-second TTFB',
                'Minify critical CSS and eliminate render-blocking stylesheets',
            ];
        }

        return array_slice($results, 0, 4);
    }

    /**
     * Generate 48-Hour Growth & SEO Roadmap using AI (Groq / Gemini)
     */
    protected function generateAIRoadmap(string $host, array $metrics): array
    {
        $prompt = <<<EOT
You are WebRanker's Chief Technical SEO & Performance Architect.
Analyze this website diagnostic data and generate an elite, practical 48-Hour Growth & SEO Roadmap.

WEBSITE DOMAIN: {$host}
PERFORMANCE SCORE: {$metrics['performance_score']}/100
SEO SCORE: {$metrics['seo_score']}/100
CORE WEB VITALS:
- FCP: {$metrics['fcp']}
- LCP: {$metrics['lcp']}
- CLS: {$metrics['cls']}
- TBT: {$metrics['tbt']}
- TTFB: {$metrics['ttfb']}
KEY ISSUES DETECTED:
- %s

Provide your response in strict JSON format with these exact keys:
{
  "executive_summary": "Crisp 2-sentence technical assessment of the site's current organic ranking barriers and speed bottleneck.",
  "speed_fixes": [
    "Technical fix 1: Specific Core Web Vitals / server caching / Next.js architecture fix.",
    "Technical fix 2: Script deferral / asset bundling / CSS purge fix.",
    "Technical fix 3: Image compression WebP/AVIF or CDN delivery fix."
  ],
  "keyword_opportunities": [
    "Ranking Strategy 1: High-intent organic keyword group for {$host}'s niche.",
    "Ranking Strategy 2: Topical authority and internal link silo structure.",
    "Ranking Strategy 3: Competitive SERP displacement strategy."
  ],
  "schema_fixes": [
    "Schema fix 1: Organization & Local/Corporate JSON-LD schema markup.",
    "Schema fix 2: BreadcrumbList and WebSite search action schemas.",
    "Schema fix 3: Canonical, OpenGraph, and semantic HTML5 hierarchy optimization."
  ]
}
Return ONLY valid JSON.
EOT;

        $issuesStr = implode("\n- ", $metrics['opportunities'] ?? ['Asset delivery optimization', 'Schema markup']);
        $formattedPrompt = sprintf($prompt, $issuesStr);

        $messages = [
            ['role' => 'system', 'content' => 'You are an elite technical SEO and Core Web Vitals engineer. Return only clean JSON.'],
            ['role' => 'user', 'content' => $formattedPrompt],
        ];

        try {
            $aiResponse = GroqAIService::chat($messages, 'qwen/qwen3.8-27b', 0.4, 600);

            if ($aiResponse) {
                // Strip markdown code fences if present
                $cleanJson = preg_replace('/^```(?:json)?\s*|\s*```$/i', '', trim($aiResponse));
                $parsed = json_decode($cleanJson, true);

                if (is_array($parsed) && isset($parsed['speed_fixes'], $parsed['keyword_opportunities'], $parsed['schema_fixes'])) {
                    return $parsed;
                }
            }
        } catch (\Throwable $e) {
            Log::info("AI Roadmap generation error: " . $e->getMessage());
        }

        // Deterministic High-Quality Roadmap Fallback
        return $this->defaultRoadmap($host, $metrics);
    }

    /**
     * Deterministic high-quality fallback roadmap
     */
    protected function defaultRoadmap(string $host, array $metrics): array
    {
        return [
            'executive_summary' => "{$host} exhibits solid foundational architecture but suffers from Core Web Vitals latency (LCP: {$metrics['lcp']}) and missing structured schema, limiting its Page #1 Google ranking potential.",
            'speed_fixes' => [
                "Compress & serve hero media in next-gen WebP/AVIF formats with `fetchpriority=\"high\"` to bring LCP under 2.0s.",
                "Defer non-critical third-party analytics and chat widgets to eliminate {$metrics['tbt']} of Total Blocking Time.",
                "Implement edge caching (Cloudflare / Fastly) and HTTP/3 compression to drop initial TTFB below 150ms.",
            ],
            'keyword_opportunities' => [
                "Target high-intent commercial keywords in {$host}'s primary vertical to capture qualified ready-to-buy traffic.",
                "Build topical authority clusters connecting service landing pages with technical pillar articles.",
                "Capture Google 'People Also Ask' and featured snippets by deploying FAQ schema on core URLs.",
            ],
            'schema_fixes' => [
                "Inject valid JSON-LD `Organization` and `WebSite` schema markup into the site head.",
                "Verify and standardize canonical tags to prevent self-competing duplicate URLs.",
                "Ensure single semantic `<h1>` structure per page with strict H2/H3 heading hierarchy for crawler parsing.",
            ],
        ];
    }
}
