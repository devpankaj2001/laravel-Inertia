<?php

namespace App\Http\Controllers;

use App\Models\IndustryDomain;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class IndustryPageController extends Controller
{
    /**
     * Display the industries & vertical solutions directory.
     */
    public function index(Request $request)
    {
        $selectedGroup = $request->query('group', 'all');
        $searchQuery = $request->query('search', '');

        $query = IndustryDomain::active();

        if (!empty($selectedGroup) && strtolower($selectedGroup) !== 'all') {
            $query->where('category_group', $selectedGroup);
        }

        if (!empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('name', 'like', "%{$searchQuery}%")
                  ->orWhere('description', 'like', "%{$searchQuery}%")
                  ->orWhere('hero_tagline', 'like', "%{$searchQuery}%")
                  ->orWhere('category_group', 'like', "%{$searchQuery}%");
            });
        }

        $industries = $query->paginate(12)->withQueryString();

        // Available groups with counts
        $categoryGroups = IndustryDomain::where('is_active', true)
            ->whereNotNull('category_group')
            ->select('category_group')
            ->selectRaw('count(*) as count')
            ->groupBy('category_group')
            ->orderBy('category_group', 'asc')
            ->get();

        $totalIndustriesCount = IndustryDomain::where('is_active', true)->count();

        // SEO meta
        $metaTitle = "Industry Vertical Solutions | Enterprise Digital Engineering & SEO | WebRanker";
        $metaDescription = "Explore WebRanker's 25+ industry domain solutions: tailor-made full-stack architectures, compliance-ready platforms (HIPAA, PCI-DSS, SOC2), and search domination.";
        $canonicalUrl = route('industries.index');
        $ogImage = asset('asset/logo.svg');

        // Schema.org CollectionPage & BreadcrumbList
        $schemas = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => $metaTitle,
                'description' => $metaDescription,
                'url' => $canonicalUrl,
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    [
                        '@type' => 'ListItem',
                        'position' => 1,
                        'name' => 'Home',
                        'item' => url('/'),
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 2,
                        'name' => 'Industries',
                        'item' => $canonicalUrl,
                    ],
                ],
            ],
        ];

        return view('industries.index', compact(
            'industries',
            'categoryGroups',
            'selectedGroup',
            'searchQuery',
            'totalIndustriesCount',
            'metaTitle',
            'metaDescription',
            'canonicalUrl',
            'ogImage',
            'schemas'
        ));
    }

    /**
     * Display a single detailed industry vertical showcase.
     */
    public function show(string $slug)
    {
        $industry = IndustryDomain::active()->where('slug', $slug)->firstOrFail();

        // Related industries in same category or adjacent
        $relatedIndustries = IndustryDomain::active()
            ->where('id', '!=', $industry->id)
            ->where(function ($q) use ($industry) {
                if (!empty($industry->category_group)) {
                    $q->where('category_group', $industry->category_group);
                }
            })
            ->take(3)
            ->get();

        if ($relatedIndustries->count() < 3) {
            $fallback = IndustryDomain::active()
                ->where('id', '!=', $industry->id)
                ->whereNotIn('id', $relatedIndustries->pluck('id'))
                ->take(3 - $relatedIndustries->count())
                ->get();
            $relatedIndustries = $relatedIndustries->merge($fallback);
        }

        // Top Services for consultation bridge
        $featuredServices = Service::active()->take(3)->get();

        // SEO meta
        $metaTitle = $industry->seo_title;
        $metaDescription = $industry->seo_description;
        $canonicalUrl = route('industries.show', $industry->slug);
        $ogImage = $industry->featured_image_url;

        // Structured Data: Service / Organization / Breadcrumbs / FAQs
        $schemas = [];

        // 1. Service / ProfessionalService Schema
        $schemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'ProfessionalService',
            'name' => "{$industry->name} Digital Engineering & Architecture",
            'description' => $metaDescription,
            'url' => $canonicalUrl,
            'image' => $ogImage,
            'provider' => [
                '@type' => 'Organization',
                'name' => 'WebRanker Technologies',
                'url' => url('/'),
                'logo' => asset('asset/logo.svg'),
            ],
            'areaServed' => 'Global',
            'serviceType' => "Custom Enterprise Software & SEO for {$industry->name}",
        ];

        // 2. Breadcrumbs Schema
        $schemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => url('/'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Industries',
                    'item' => route('industries.index'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $industry->name,
                    'item' => $canonicalUrl,
                ],
            ],
        ];

        // 3. FAQ Schema
        if (!empty($industry->faqs) && is_array($industry->faqs)) {
            $faqElements = [];
            foreach ($industry->faqs as $faq) {
                if (!empty($faq['question']) && !empty($faq['answer'])) {
                    $faqElements[] = [
                        '@type' => 'Question',
                        'name' => $faq['question'],
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => strip_tags($faq['answer']),
                        ],
                    ];
                }
            }
            if (!empty($faqElements)) {
                $schemas[] = [
                    '@context' => 'https://schema.org',
                    '@type' => 'FAQPage',
                    'mainEntity' => $faqElements,
                ];
            }
        }

        return view('industries.show', compact(
            'industry',
            'relatedIndustries',
            'featuredServices',
            'metaTitle',
            'metaDescription',
            'canonicalUrl',
            'ogImage',
            'schemas'
        ));
    }
}
