<?php

namespace App\Http\Controllers;

use App\Jobs\ScoreLeadJob;
use App\Models\Inquiry;
use App\Models\SeoBacklinkAudit;
use App\Models\SeoKeywordRanking;
use App\Services\BacklinkService;
use App\Services\GeoIPService;
use App\Services\GoogleSerpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class SEOToolsController extends Controller
{
    /**
     * Display the Free SEO & Growth Tools Hub
     */
    public function index()
    {
        return Inertia::render('Tools/Index', [
            'seo' => [
                'metaTitle' => 'Free SEO Tools & Google Growth Suite | Rankexa',
                'metaDescription' => 'Explore 100% Free SEO & Performance Tools: Google Keyword Ranking Checker, Backlink & Authority Analyzer, Real-Time Core Web Vitals Auditor, Schema Generator & SERP Simulator.',
                'metaKeywords' => 'free seo tools, google ranking checker, backlink checker, domain authority checker, schema generator, serp simulator, project cost calculator',
                'canonicalUrl' => url('/tools'),
            ],
            'recentKeywords' => SeoKeywordRanking::latest()->take(6)->get(['domain', 'keyword', 'country', 'position', 'created_at']),
            'recentAudits' => SeoBacklinkAudit::latest()->take(6)->get(['domain', 'domain_authority', 'toxic_risk', 'created_at']),
        ]);
    }

    /**
     * Display Interactive Project Cost Estimator & Proposal Generator
     */
    public function calculator()
    {
        return Inertia::render('Tools/ProjectEstimator', [
            'seo' => [
                'metaTitle' => 'Website & Web App Project Cost Calculator | Free Instant Proposal | Rankexa',
                'metaDescription' => 'Calculate your custom website, Next.js web application, e-commerce, or SEO overhaul investment. Get an instant itemized scope breakdown and download a branded PDF proposal.',
                'metaKeywords' => 'website cost calculator, web development pricing estimator, next.js app cost, seo pricing calculator, instant proposal generator, rankexa quote',
                'canonicalUrl' => url('/calculator'),
            ],
        ]);
    }

    /**
     * API: Save Estimate Inquiry and trigger background AI Lead Scoring
     */
    public function apiSaveEstimate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:30',
            'company' => 'nullable|string|max:150',
            'project_type' => 'required|string|max:100',
            'estimated_price' => 'required|string|max:60',
            'currency' => 'nullable|string|max:10',
            'timeline' => 'nullable|string|max:60',
            'features' => 'nullable|array',
            'notes' => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $clientIp = GeoIPService::getClientIp($request);
        $country = GeoIPService::getCountry($clientIp, $request);

        $featureList = !empty($request->features) ? implode(', ', $request->features) : 'Standard Architecture';
        $summary = "Custom Scope Estimate: {$request->project_type} ({$request->estimated_price}). Timeline: {$request->timeline}. Features: {$featureList}.";
        if ($request->filled('notes')) {
            $summary .= " Notes: {$request->notes}";
        }

        $inquiry = Inquiry::create([
            'name' => trim($request->name),
            'email' => trim($request->email),
            'phone' => $request->phone,
            'company' => $request->company,
            'service_interest' => 'Proposal: ' . $request->project_type,
            'budget' => $request->estimated_price,
            'message' => $summary,
            'source_url' => $request->header('referer', url('/calculator')),
            'ip_address' => $clientIp,
            'country' => $country,
            'user_agent' => $request->userAgent(),
            'status' => 'new',
            'lead_intent' => 'Hot',
            'lead_score' => 88,
        ]);

        // Background AI evaluation & alert
        ScoreLeadJob::dispatchAfterResponse($inquiry->id);

        return response()->json([
            'success' => true,
            'message' => 'Your custom project estimate and proposal has been registered! Our team will reach out with the finalized contract and kickoff details.',
            'inquiry_id' => $inquiry->id,
        ]);
    }

    /**
     * Display Google SERP Simulator & Schema Generator Tool
     */
    public function schemaGenerator(Request $request)
    {
        return Inertia::render('Tools/SchemaGenerator', [
            'initialTab' => $request->query('tab', 'serp'),
            'seo' => [
                'metaTitle' => 'Free Google SERP Snippet Simulator & Schema JSON-LD Generator | Rankexa',
                'metaDescription' => 'Simulate Google desktop & mobile search snippets in real time with pixel counters. Generate rich snippet Schema JSON-LD for FAQ, Local Business, Article, and Products.',
                'metaKeywords' => 'google serp simulator, serp snippet preview, schema json-ld generator, rich snippet creator, faq schema generator, local business schema',
                'canonicalUrl' => url('/tools/schema-generator'),
            ],
        ]);
    }

    /**
     * Display Google Keyword Rank Checker Tool page
     */
    public function rankChecker()
    {
        return Inertia::render('Tools/RankChecker', [
            'seo' => [
                'metaTitle' => 'Free Google Keyword Ranking Checker | Rankexa',
                'metaDescription' => 'Check your exact Google SERP position, analyze top 3 ranking competitors, and get instant AI roadmap recommendations to rank on Page 1.',
                'metaKeywords' => 'google keyword rank checker, free serp checker, check google position, keyword ranking tracker, seo rank finder',
                'canonicalUrl' => url('/tools/google-ranking-checker'),
            ],
        ]);
    }

    /**
     * API: Execute Google Keyword Ranking Check
     */
    public function apiCheckRanking(Request $request, GoogleSerpService $serpService)
    {
        $ip = $request->ip();
        $rateKey = 'serp-check:' . $ip;

        if (RateLimiter::tooManyAttempts($rateKey, 15)) {
            $seconds = RateLimiter::availableIn($rateKey);
            return response()->json([
                'success' => false,
                'message' => "Rate limit exceeded. Please wait {$seconds} seconds before running another rank check.",
            ], 429);
        }

        RateLimiter::hit($rateKey, 60);

        $validated = $request->validate([
            'domain' => ['required', 'string', 'max:255'],
            'keyword' => ['required', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:10'],
            'email' => ['nullable', 'email', 'max:150'],
        ]);

        try {
            $result = $serpService->checkRanking(
                $validated['domain'],
                $validated['keyword'],
                $validated['country'] ?? 'in',
                $validated['email'] ?? null,
                $ip
            );

            return response()->json([
                'success' => true,
                'data' => $result,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to check ranking: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display Backlink & Domain Authority Checker Tool page
     */
    public function backlinkChecker()
    {
        return Inertia::render('Tools/BacklinkChecker', [
            'seo' => [
                'metaTitle' => 'Free Backlink & Domain Authority Checker | Rankexa',
                'metaDescription' => 'Analyze your website Domain Authority (DA), PageRank, Dofollow vs Nofollow ratio, toxic link risks, and discover high-impact link opportunities with AI.',
                'metaKeywords' => 'free backlink checker, domain authority checker, pagerank checker, link equity audit, toxic backlink finder, ai link building',
                'canonicalUrl' => url('/tools/backlink-checker'),
            ],
        ]);
    }

    /**
     * API: Execute Backlink & Domain Authority Check
     */
    public function apiCheckBacklinks(Request $request, BacklinkService $backlinkService)
    {
        $ip = $request->ip();
        $rateKey = 'backlink-check:' . $ip;

        if (RateLimiter::tooManyAttempts($rateKey, 15)) {
            $seconds = RateLimiter::availableIn($rateKey);
            return response()->json([
                'success' => false,
                'message' => "Rate limit exceeded. Please wait {$seconds} seconds before running another backlink audit.",
            ], 429);
        }

        RateLimiter::hit($rateKey, 60);

        $validated = $request->validate([
            'domain' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:150'],
        ]);

        try {
            $result = $backlinkService->auditDomain(
                $validated['domain'],
                $validated['email'] ?? null,
                $ip
            );

            return response()->json([
                'success' => true,
                'data' => $result,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to audit backlinks: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Admin: Tools Activity & Lead Pipeline
     */
    public function adminToolsActivity(Request $request)
    {
        $keywordRankings = SeoKeywordRanking::latest()->paginate(15, ['*'], 'keywords_page');
        $backlinkAudits = SeoBacklinkAudit::latest()->paginate(15, ['*'], 'backlinks_page');

        return view('admin.tools.index', compact('keywordRankings', 'backlinkAudits'));
    }
}
