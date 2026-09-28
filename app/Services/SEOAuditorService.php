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
            'best_practices_score' => $metrics['best_practices_score'] ?? 92,
            'accessibility_score' => $metrics['accessibility_score'] ?? 90,
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

        // Query all 4 Lighthouse categories (Free)
        $fullUrl = $apiUrl . '?url=' . urlencode($url) . '&strategy=mobile&category=performance&category=seo&category=best-practices&category=accessibility';
        if (!empty($apiKey)) {
            $fullUrl .= '&key=' . urlencode($apiKey);
        }

        try {
            $response = Http::timeout(10)->withoutVerifying()->get($fullUrl);

            if ($response->successful()) {
                $data = $response->json();
                $lighthouse = $data['lighthouseResult'] ?? [];
                $categories = $lighthouse['categories'] ?? [];

                $perfScore = isset($categories['performance']['score'])
                    ? (int) round($categories['performance']['score'] * 100)
                    : 74;

                $seoScore = isset($categories['seo']['score'])
                    ? (int) round($categories['seo']['score'] * 100)
                    : 84;

                $bpScore = isset($categories['best-practices']['score'])
                    ? (int) round($categories['best-practices']['score'] * 100)
                    : 88;

                $a11yScore = isset($categories['accessibility']['score'])
                    ? (int) round($categories['accessibility']['score'] * 100)
                    : 86;

                $audits = $lighthouse['audits'] ?? [];

                $fcp = $audits['first-contentful-paint']['displayValue'] ?? '1.6 s';
                $lcp = $audits['largest-contentful-paint']['displayValue'] ?? '2.8 s';
                $cls = $audits['cumulative-layout-shift']['displayValue'] ?? '0.08';
                $tbt = $audits['total-blocking-time']['displayValue'] ?? '180 ms';
                $speedIndex = $audits['speed-index']['displayValue'] ?? '2.1 s';
                $ttfb = $audits['server-response-time']['displayValue'] ?? '420 ms';

                // Numeric values for CWV status calculation
                $fcpNum = ($audits['first-contentful-paint']['numericValue'] ?? 1600) / 1000;
                $lcpNum = ($audits['largest-contentful-paint']['numericValue'] ?? 2800) / 1000;
                $clsNum = (float) ($audits['cumulative-layout-shift']['numericValue'] ?? 0.08);
                $ttfbNum = ($audits['server-response-time']['numericValue'] ?? 420);
                $tbtNum = ($audits['total-blocking-time']['numericValue'] ?? 180);

                $cwvDetails = $this->buildCwvDetails($fcp, $fcpNum, $lcp, $lcpNum, $cls, $clsNum, $ttfb, $ttfbNum, $tbt, $tbtNum);

                // Build pass/fail checklist from Google audits
                $checklist = [
                    [
                        'name' => 'SSL / HTTPS Enforced',
                        'category' => 'Security',
                        'passed' => ($audits['is-on-https']['score'] ?? 1) == 1,
                        'description' => 'Secure HTTPS protocol safeguards traffic, protecting user credentials and ranking signals.',
                    ],
                    [
                        'name' => 'Mobile Viewport Meta Tag',
                        'category' => 'Mobile',
                        'passed' => ($audits['viewport']['score'] ?? 1) == 1,
                        'description' => 'Mobile viewport is configured, rendering cleanly across smartphones and tablets.',
                    ],
                    [
                        'name' => 'Search-Optimized Title Tag',
                        'category' => 'SEO',
                        'passed' => ($audits['document-title']['score'] ?? 1) == 1,
                        'description' => 'Document title is present and properly weighted for Google search result CTR.',
                    ],
                    [
                        'name' => 'Meta Description Optimization',
                        'category' => 'SEO',
                        'passed' => ($audits['meta-description']['score'] ?? 1) == 1,
                        'description' => 'Meta description is populated to provide clear search snippet summaries.',
                    ],
                    [
                        'name' => 'Structured Data (JSON-LD Schema)',
                        'category' => 'SEO',
                        'passed' => ($audits['structured-data']['score'] ?? 0) >= 0.8,
                        'description' => 'Schema markup helps search engines understand organization entity details.',
                    ],
                    [
                        'name' => 'Self-Referencing Canonical Tag',
                        'category' => 'SEO',
                        'passed' => ($audits['canonical']['score'] ?? 1) == 1,
                        'description' => 'Prevents duplicate content indexation across multiple domain parameters.',
                    ],
                    [
                        'name' => 'Image Accessibility (Alt Attributes)',
                        'category' => 'Accessibility',
                        'passed' => ($audits['image-alt']['score'] ?? 1) == 1,
                        'description' => 'Images feature descriptive alt attributes for screen readers and Google Image search.',
                    ],
                    [
                        'name' => 'Modern Next-Gen Images (WebP/AVIF)',
                        'category' => 'Performance',
                        'passed' => ($audits['modern-image-formats']['score'] ?? 0) >= 0.7,
                        'description' => 'Serving modern image formats reduces payload by up to 60%.',
                    ],
                    [
                        'name' => 'Server Response Latency (TTFB)',
                        'category' => 'Performance',
                        'passed' => $ttfbNum <= 600,
                        'description' => 'Fast server time to first byte ensures rapid browser asset painting.',
                    ],
                    [
                        'name' => 'Render-Blocking Script Deferral',
                        'category' => 'Performance',
                        'passed' => ($audits['render-blocking-resources']['score'] ?? 0) >= 0.8,
                        'description' => 'Scripts and stylesheets load asynchronously without freezing initial view.',
                    ],
                ];

                return [
                    'source' => 'google_pagespeed',
                    'performance_score' => $perfScore,
                    'seo_score' => $seoScore,
                    'best_practices_score' => $bpScore,
                    'accessibility_score' => $a11yScore,
                    'fcp' => $fcp,
                    'lcp' => $lcp,
                    'cls' => $cls,
                    'tbt' => $tbt,
                    'speed_index' => $speedIndex,
                    'ttfb' => $ttfb,
                    'cwv_status' => ($perfScore >= 85) ? 'PASS' : (($perfScore >= 50) ? 'NEEDS WORK' : 'POOR'),
                    'cwv_details' => $cwvDetails,
                    'checklist' => $checklist,
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
     * Build standard Core Web Vitals rating details
     */
    protected function buildCwvDetails($fcp, $fcpNum, $lcp, $lcpNum, $cls, $clsNum, $ttfb, $ttfbNum, $tbt, $tbtNum): array
    {
        return [
            'fcp' => [
                'value' => $fcp,
                'raw' => $fcpNum,
                'status' => $fcpNum <= 1.8 ? 'good' : ($fcpNum <= 3.0 ? 'needs_improvement' : 'poor'),
                'benchmark' => '≤ 1.8s',
                'title' => 'First Contentful Paint',
                'description' => 'Measures when the first DOM content (text or image) is rendered.',
            ],
            'lcp' => [
                'value' => $lcp,
                'raw' => $lcpNum,
                'status' => $lcpNum <= 2.5 ? 'good' : ($lcpNum <= 4.0 ? 'needs_improvement' : 'poor'),
                'benchmark' => '≤ 2.5s',
                'title' => 'Largest Contentful Paint',
                'description' => 'Measures perceived load speed when the main hero block has loaded.',
            ],
            'cls' => [
                'value' => $cls,
                'raw' => $clsNum,
                'status' => $clsNum <= 0.1 ? 'good' : ($clsNum <= 0.25 ? 'needs_improvement' : 'poor'),
                'benchmark' => '≤ 0.10',
                'title' => 'Cumulative Layout Shift',
                'description' => 'Measures visual stability and unexpected layout shifting on screen.',
            ],
            'ttfb' => [
                'value' => $ttfb,
                'raw' => $ttfbNum,
                'status' => $ttfbNum <= 200 ? 'good' : ($ttfbNum <= 600 ? 'needs_improvement' : 'poor'),
                'benchmark' => '≤ 200ms',
                'title' => 'Server Response (TTFB)',
                'description' => 'Measures server latency and how fast DNS + initial byte arrives.',
            ],
            'tbt' => [
                'value' => $tbt,
                'raw' => $tbtNum,
                'status' => $tbtNum <= 200 ? 'good' : ($tbtNum <= 600 ? 'needs_improvement' : 'poor'),
                'benchmark' => '≤ 200ms',
                'title' => 'Total Blocking Time',
                'description' => 'Measures total amount of time main thread was blocked by JS tasks.',
            ],
        ];
    }

    /**
     * Heuristic live analyzer for immediate diagnostic when PageSpeed API is unavailable/slow
     */
    protected function heuristicSiteAudit(string $url, string $host): array
    {
        $startTime = microtime(true);
        $html = '';
        $statusCode = 200;
        $isHttps = str_starts_with($url, 'https://');

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
        $descLength = $hasMetaDesc ? strlen(trim($mDesc[1])) : 0;
        $descGood = $hasMetaDesc && ($descLength >= 70 && $descLength <= 165);

        $hasViewport = (bool) preg_match('/<meta[^>]+name=[\'"]viewport[\'"]/is', $html);
        $hasCanonical = (bool) preg_match('/<link[^>]+rel=[\'"]canonical[\'"]/is', $html);
        $hasSchema = (bool) preg_match('/<script[^>]+type=[\'"]application\/ld\+json[\'"]/is', $html);
        $hasOg = (bool) preg_match('/<meta[^>]+property=[\'"]og:(?:image|title)[\'"]/is', $html);
        $hasDoctype = (bool) preg_match('/<!DOCTYPE\s+html>/is', $html);
        $hasHtmlLang = (bool) preg_match('/<html[^>]+lang=[\'"][a-zA-Z0-9_-]+[\'"]/is', $html);

        $h1Count = preg_match_all('/<h1[^>]*>/is', $html);
        $imgCount = preg_match_all('/<img[^>]*>/is', $html, $mImgs);
        $imgWithAlt = 0;
        if ($imgCount > 0 && isset($mImgs[0])) {
            foreach ($mImgs[0] as $tag) {
                if (preg_match('/alt=[\'"][^\'"]*[\'"]/i', $tag)) {
                    $imgWithAlt++;
                }
            }
        }
        $imgAltGood = ($imgCount === 0 || ($imgWithAlt / max(1, $imgCount)) >= 0.7);

        // Check modern image formats
        $hasModernImages = (bool) preg_match('/\.(?:webp|avif|svg)[\'"]/is', $html);

        // Check script async/defer tags
        preg_match_all('/<script[^>]*src=[\'"][^\'"]+[\'"][^>]*>/is', $html, $mScripts);
        $totalScripts = count($mScripts[0] ?? []);
        $asyncScripts = 0;
        if ($totalScripts > 0) {
            foreach ($mScripts[0] as $sTag) {
                if (stripos($sTag, 'async') !== false || stripos($sTag, 'defer') !== false) {
                    $asyncScripts++;
                }
            }
        }
        $scriptsDeferred = ($totalScripts === 0 || ($asyncScripts / max(1, $totalScripts)) >= 0.6);

        // Compute realistic Technical SEO score (0-100)
        $seoScore = 50;
        if ($titleGood) $seoScore += 12;
        elseif ($hasTitle) $seoScore += 6;
        if ($descGood) $seoScore += 12;
        elseif ($hasMetaDesc) $seoScore += 6;
        if ($hasViewport) $seoScore += 8;
        if ($hasCanonical) $seoScore += 6;
        if ($hasSchema) $seoScore += 8;
        if ($hasOg) $seoScore += 5;
        if ($h1Count === 1) $seoScore += 5;
        elseif ($h1Count > 1) $seoScore += 2;
        $seoScore = min(98, max(42, $seoScore));

        // Compute realistic Performance Score based on real TTFB & payload
        $perfScore = 88;
        if ($durationMs > 1000) $perfScore -= 20;
        elseif ($durationMs > 600) $perfScore -= 12;
        elseif ($durationMs > 350) $perfScore -= 6;

        if (strlen($html) > 300000) $perfScore -= 12;
        elseif (strlen($html) > 150000) $perfScore -= 6;

        if (!$hasModernImages && $imgCount > 3) $perfScore -= 5;
        if (!$scriptsDeferred && $totalScripts > 3) $perfScore -= 5;
        $perfScore = min(96, max(38, $perfScore));

        // Best Practices & Accessibility scores
        $bpScore = 82;
        if ($isHttps) $bpScore += 8;
        if ($hasDoctype) $bpScore += 5;
        if ($hasModernImages) $bpScore += 5;
        $bpScore = min(98, max(50, $bpScore));

        $a11yScore = 78;
        if ($hasViewport) $a11yScore += 8;
        if ($hasHtmlLang) $a11yScore += 7;
        if ($imgAltGood) $a11yScore += 7;
        $a11yScore = min(96, max(48, $a11yScore));

        // Core Web Vitals estimates
        $fcpEstVal = max(0.8, round(($durationMs / 1000) * 1.3, 1));
        $fcpEst = $fcpEstVal . ' s';
        $lcpEstVal = max(1.6, round(($durationMs / 1000) * 2.3, 1));
        $lcpEst = $lcpEstVal . ' s';
        $clsEstVal = $hasViewport ? 0.04 : 0.16;
        $clsEst = (string) $clsEstVal;
        $tbtEstVal = max(50, min(500, (int) round($durationMs * 0.4)));
        $tbtEst = $tbtEstVal . ' ms';
        $ttfbEst = $durationMs . ' ms';

        $cwvDetails = $this->buildCwvDetails($fcpEst, $fcpEstVal, $lcpEst, $lcpEstVal, $clsEst, $clsEstVal, $ttfbEst, $durationMs, $tbtEst, $tbtEstVal);

        $checklist = [
            [
                'name' => 'SSL / HTTPS Security',
                'category' => 'Security',
                'passed' => $isHttps,
                'description' => $isHttps ? 'Traffic is encrypted over SSL/HTTPS.' : 'HTTPS redirect missing; vulnerable to security warnings.',
            ],
            [
                'name' => 'Mobile Responsive Viewport',
                'category' => 'Mobile',
                'passed' => $hasViewport,
                'description' => $hasViewport ? 'Responsive viewport configured for all mobile devices.' : 'Missing viewport tag; mobile layout may clip or zoom out.',
            ],
            [
                'name' => 'Search-Optimized Title Tag',
                'category' => 'SEO',
                'passed' => $hasTitle && $titleGood,
                'description' => $titleGood ? "Title length ({$titleLength} chars) fits Google SERP width." : 'Title tag missing or non-optimal length (recommended: 30-65 chars).',
            ],
            [
                'name' => 'Meta Description CTR Optimization',
                'category' => 'SEO',
                'passed' => $descGood,
                'description' => $descGood ? "Meta description ({$descLength} chars) provides ideal search snippet." : 'Meta description is missing or too short/long for SERP visibility.',
            ],
            [
                'name' => 'Structured Data (JSON-LD Schema)',
                'category' => 'SEO',
                'passed' => $hasSchema,
                'description' => $hasSchema ? 'JSON-LD schema markup detected for rich snippet eligibility.' : 'Missing Schema.org structured data (Organization, WebSite).',
            ],
            [
                'name' => 'Single H1 Semantic Hierarchy',
                'category' => 'SEO',
                'passed' => ($h1Count === 1),
                'description' => ($h1Count === 1) ? 'Single primary <h1> provides unambiguous topical focus.' : "Found {$h1Count} <h1> tags. Google prefers exactly one primary H1 header.",
            ],
            [
                'name' => 'Self-Referencing Canonical Tag',
                'category' => 'SEO',
                'passed' => $hasCanonical,
                'description' => $hasCanonical ? 'Canonical tag protects against duplicate content indexation.' : 'Missing canonical link tag in HTML head.',
            ],
            [
                'name' => 'Image Accessibility (Alt Attributes)',
                'category' => 'Accessibility',
                'passed' => $imgAltGood,
                'description' => $imgAltGood ? 'Images have alt text for screen readers and SEO.' : 'Several images lack descriptive alt text attributes.',
            ],
            [
                'name' => 'Server Response Latency (TTFB)',
                'category' => 'Performance',
                'passed' => ($durationMs <= 600),
                'description' => ($durationMs <= 600) ? "Server responded in {$durationMs}ms (healthy latency)." : "Slow server response ({$durationMs}ms) delays page loading.",
            ],
            [
                'name' => 'Modern Image Formats (WebP/AVIF)',
                'category' => 'Performance',
                'passed' => $hasModernImages,
                'description' => $hasModernImages ? 'Modern WebP/AVIF image formats detected.' : 'Legacy JPG/PNG assets could be compressed to WebP/AVIF.',
            ],
        ];

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
        if (!$hasModernImages) {
            $opportunities[] = 'Serve hero banners and responsive images in modern WebP/AVIF formats';
        }
        if (!$scriptsDeferred) {
            $opportunities[] = 'Defer non-critical third-party JavaScript & unminified stylesheets';
        }

        return [
            'source' => 'live_heuristic_diagnostic',
            'performance_score' => $perfScore,
            'seo_score' => $seoScore,
            'best_practices_score' => $bpScore,
            'accessibility_score' => $a11yScore,
            'fcp' => $fcpEst,
            'lcp' => $lcpEst,
            'cls' => $clsEst,
            'tbt' => $tbtEst,
            'speed_index' => number_format(max(1.4, ($durationMs / 1000) * 1.8), 1) . ' s',
            'ttfb' => $ttfbEst,
            'cwv_status' => ($perfScore >= 85) ? 'PASS' : (($perfScore >= 60) ? 'NEEDS WORK' : 'POOR'),
            'cwv_details' => $cwvDetails,
            'checklist' => $checklist,
            'opportunities' => array_slice($opportunities, 0, 5),
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
BEST PRACTICES: {$metrics['best_practices_score']}/100
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
