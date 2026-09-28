<?php

namespace App\Http\Controllers;

use App\Models\SeoBacklinkAudit;
use App\Models\SeoKeywordRanking;
use App\Services\BacklinkService;
use App\Services\GoogleSerpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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
                'metaDescription' => 'Explore 100% Free SEO & Performance Tools: Google Keyword Ranking Checker, Backlink & Authority Analyzer, Real-Time Core Web Vitals Auditor, and SERP Snippet Optimizer.',
                'metaKeywords' => 'free seo tools, google ranking checker, backlink checker, domain authority checker, core web vitals auditor, serp position checker',
                'canonicalUrl' => url('/tools'),
            ],
            'recentKeywords' => SeoKeywordRanking::latest()->take(6)->get(['domain', 'keyword', 'country', 'position', 'created_at']),
            'recentAudits' => SeoBacklinkAudit::latest()->take(6)->get(['domain', 'domain_authority', 'toxic_risk', 'created_at']),
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
