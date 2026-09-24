<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServicePageController extends Controller
{
    /**
     * Display the services directory.
     */
    public function index(Request $request)
    {
        $categoryFilter = $request->query('category');
        $query = Service::active();

        if (!empty($categoryFilter)) {
            $query->where('category', $categoryFilter);
        }

        $allServices = $query->get();
        $categories = Service::select('category')->distinct()->pluck('category')->filter()->values();

        $metaTitle = "Enterprise Web, App & SEO Services Catalog | WebRanker";
        $metaDescription = "Explore WebRanker's full suite of engineering, technical SEO, mobile application, and AI automation solutions engineered for #1 organic rankings and sub-second performance.";
        $metaKeywords = "web development services, technical SEO services, mobile app development, custom software, digital marketing";
        $canonicalUrl = url('/services');
        $ogImage = asset('asset/logo.svg');

        // Breadcrumb Schema for Directory
        $schemas = [
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
                        'name' => 'Services',
                        'item' => url('/services'),
                    ],
                ],
            ],
        ];

        $contentHtml = view('services.index_content', compact(
            'allServices',
            'categories',
            'categoryFilter',
            'metaTitle',
            'metaDescription',
            'metaKeywords',
            'canonicalUrl',
            'ogImage',
            'schemas'
        ))->render();

        return Inertia::render('Services/Index', [
            'contentHtml' => $contentHtml,
            'allServices' => $allServices,
            'categories' => $categories,
            'categoryFilter' => $categoryFilter,
            'seo' => [
                'metaTitle' => $metaTitle,
                'metaDescription' => $metaDescription,
                'metaKeywords' => $metaKeywords,
                'canonicalUrl' => $canonicalUrl,
                'ogImage' => $ogImage,
                'schemas' => $schemas,
            ],
        ]);
    }

    /**
     * Display a dedicated, individual service landing page with full SEO & Schema suite.
     */
    public function show(string $slug)
    {
        $service = Service::where('slug', $slug)->active()->firstOrFail();

        // Related services within same category
        $relatedServices = Service::where('category', $service->category)
            ->where('id', '!=', $service->id)
            ->active()
            ->take(3)
            ->get();

        // Meta Tags
        $metaTitle = $service->seo_title;
        $metaDescription = $service->seo_description;
        $metaKeywords = $service->seo_keywords;
        $canonicalUrl = url("/services/{$service->slug}");
        $ogImage = $service->og_image ? asset($service->og_image) : asset('asset/logo.svg');

        // Retrieve LocalBusiness & Organization settings
        $localBusinessData = SiteSetting::get('schema_local_business', [
            'name' => 'WebRanker Technologies HQ',
            'legal_name' => 'WebRanker Digital & Engineering Solutions Pvt. Ltd.',
            'image' => asset('asset/logo.svg'),
            'telephone' => '+91 97185 70218',
            'email' => 'growth@webranker.com',
            'street_address' => 'Plot no. 51, Shaheed Amit Bhardwaj Marg, opp. 8/1, Sector 8, Malviya Nagar',
            'address_locality' => 'Jaipur',
            'address_region' => 'Rajasthan',
            'postal_code' => '302017',
            'address_country' => 'IN',
            'latitude' => '26.844394',
            'longitude' => '75.805302',
            'price_range' => '$$$',
            'opening_hours' => 'Mo-Fr 09:00-19:00',
        ]);

        $orgData = SiteSetting::get('schema_organization', [
            'name' => 'WebRanker',
            'legal_name' => 'WebRanker Digital Global Enterprise Ltd.',
            'logo_url' => asset('asset/logo.svg'),
            'customer_service_phone' => '+91 97185 70218',
            'customer_service_email' => 'support@webranker.com',
            'social_links' => [
                'https://twitter.com/webranker',
                'https://linkedin.com/company/webranker',
                'https://github.com/webranker',
            ],
        ]);

        // 1. LOCAL BUSINESS SCHEMA (Merged with service specific override if provided)
        $customLocal = !empty($service->local_schema) && is_array($service->local_schema) ? $service->local_schema : [];
        $localSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            '@id' => url('/') . '/#localbusiness',
            'name' => $customLocal['name'] ?? ($localBusinessData['name'] ?? 'WebRanker Technologies HQ'),
            'image' => asset($customLocal['image'] ?? ($localBusinessData['image'] ?? 'asset/logo.svg')),
            'telephone' => $customLocal['telephone'] ?? ($localBusinessData['telephone'] ?? '+91 97185 70218'),
            'email' => $customLocal['email'] ?? ($localBusinessData['email'] ?? 'growth@webranker.com'),
            'url' => url('/'),
            'priceRange' => $customLocal['price_range'] ?? ($localBusinessData['price_range'] ?? '$$$'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $customLocal['street_address'] ?? ($localBusinessData['street_address'] ?? 'Plot no. 51, Shaheed Amit Bhardwaj Marg, Sector 8, Malviya Nagar'),
                'addressLocality' => $customLocal['address_locality'] ?? ($localBusinessData['address_locality'] ?? 'Jaipur'),
                'addressRegion' => $customLocal['address_region'] ?? ($localBusinessData['address_region'] ?? 'Rajasthan'),
                'postalCode' => $customLocal['postal_code'] ?? ($localBusinessData['postal_code'] ?? '302017'),
                'addressCountry' => $customLocal['address_country'] ?? ($localBusinessData['address_country'] ?? 'IN'),
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $customLocal['latitude'] ?? ($localBusinessData['latitude'] ?? '26.844394'),
                'longitude' => $customLocal['longitude'] ?? ($localBusinessData['longitude'] ?? '75.805302'),
            ],
            'openingHours' => $customLocal['opening_hours'] ?? ($localBusinessData['opening_hours'] ?? 'Mo-Fr 09:00-19:00'),
        ];

        // 2. CORPORATE BUSINESS / ORGANIZATION SCHEMA (Merged with service specific override if provided)
        $customBiz = !empty($service->business_schema) && is_array($service->business_schema) ? $service->business_schema : [];
        $orgSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            '@id' => url('/') . '/#organization',
            'name' => $customBiz['name'] ?? ($orgData['name'] ?? 'WebRanker'),
            'legalName' => $customBiz['legal_name'] ?? ($orgData['legal_name'] ?? 'WebRanker Digital Global Enterprise Ltd.'),
            'url' => url('/'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset($customBiz['logo_url'] ?? ($orgData['logo_url'] ?? 'asset/logo.svg')),
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => $customBiz['telephone'] ?? $customBiz['customer_service_phone'] ?? ($orgData['customer_service_phone'] ?? '+91 97185 70218'),
                'contactType' => 'customer service',
                'email' => $customBiz['email'] ?? $customBiz['customer_service_email'] ?? ($orgData['customer_service_email'] ?? 'support@webranker.com'),
                'areaServed' => ['IN', 'US', 'GB', 'AE', 'CA'],
                'availableLanguage' => ['English', 'Hindi'],
            ],
            'sameAs' => $customBiz['social_links'] ?? ($orgData['social_links'] ?? [
                'https://twitter.com/webranker',
                'https://linkedin.com/company/webranker',
            ]),
        ];

        // 3. SERVICE / PROFESSIONAL SERVICE SCHEMA
        $serviceFeatures = !empty($service->features) && is_array($service->features) ? $service->features : [];
        $serviceOffers = collect($serviceFeatures)->map(function ($feature) {
            return [
                '@type' => 'Offer',
                'itemOffered' => [
                    '@type' => 'Service',
                    'name' => $feature,
                ],
            ];
        })->toArray();

        $serviceSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            '@id' => $canonicalUrl . '#service',
            'name' => $service->title,
            'serviceType' => $service->category,
            'description' => $service->seo_description,
            'url' => $canonicalUrl,
            'provider' => [
                '@id' => url('/') . '/#localbusiness',
            ],
            'areaServed' => [
                ['@type' => 'Country', 'name' => 'United States'],
                ['@type' => 'Country', 'name' => 'United Kingdom'],
                ['@type' => 'Country', 'name' => 'India'],
                ['@type' => 'Country', 'name' => 'United Arab Emirates'],
                ['@type' => 'Country', 'name' => 'Australia'],
            ],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => "{$service->title} Engineering Scope",
                'itemListElement' => $serviceOffers,
            ],
        ];

        // 4. FAQPAGE SCHEMA (Google Rich Snippets)
        $faqsList = $service->resolved_faqs;
        $faqSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => collect($faqsList)->map(function ($faq) {
                return [
                    '@type' => 'Question',
                    'name' => $faq['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq['answer'],
                    ],
                ];
            })->toArray(),
        ];

        // 5. BREADCRUMBLIST SCHEMA
        $breadcrumbSchema = [
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
                    'name' => 'Services',
                    'item' => url('/services'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $service->category,
                    'item' => url('/services?category=' . urlencode($service->category)),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 4,
                    'name' => $service->title,
                    'item' => $canonicalUrl,
                ],
            ],
        ];

        // Aggregate All Schemas for Blade Header Injection
        $schemas = [
            $localSchema,
            $orgSchema,
            $serviceSchema,
            $faqSchema,
            $breadcrumbSchema,
        ];

        // 6. CUSTOM SCHEMA (Raw JSON-LD injected by Admin for this specific service)
        if (!empty($service->custom_schema)) {
            $rawCustom = trim($service->custom_schema);
            $rawCustom = preg_replace('#<\/?script[^>]*>#i', '', $rawCustom);
            $decodedCustom = json_decode($rawCustom, true);
            if (json_last_error() === JSON_ERROR_NONE && !empty($decodedCustom)) {
                if (isset($decodedCustom['@context']) || isset($decodedCustom['@type'])) {
                    $schemas[] = $decodedCustom;
                } elseif (is_array($decodedCustom)) {
                    foreach ($decodedCustom as $schemaItem) {
                        if (is_array($schemaItem)) {
                            $schemas[] = $schemaItem;
                        }
                    }
                }
            }
        }

        // Strategic Interlinking: Related Authority Blog Articles & Case Studies
        $relatedBlogs = BlogPost::published()
            ->where(function ($q) use ($service) {
                $q->where('category', $service->category)
                  ->orWhere('tags', 'like', "%{$service->category}%")
                  ->orWhere('title', 'like', "%{$service->title}%");
            })
            ->take(3)
            ->get();

        if ($relatedBlogs->count() < 3) {
            $fallback = BlogPost::published()
                ->whereNotIn('id', $relatedBlogs->pluck('id'))
                ->take(3 - $relatedBlogs->count())
                ->get();
            $relatedBlogs = $relatedBlogs->merge($fallback);
        }

        $contentHtml = view('services.show_content', compact(
            'service',
            'relatedServices',
            'relatedBlogs',
            'faqsList',
            'metaTitle',
            'metaDescription',
            'metaKeywords',
            'canonicalUrl',
            'ogImage',
            'schemas'
        ))->render();

        return Inertia::render('Services/Show', [
            'contentHtml' => $contentHtml,
            'service' => $service,
            'relatedServices' => $relatedServices,
            'relatedBlogs' => $relatedBlogs,
            'faqsList' => $faqsList,
            'seo' => [
                'metaTitle' => $metaTitle,
                'metaDescription' => $metaDescription,
                'metaKeywords' => $metaKeywords,
                'canonicalUrl' => $canonicalUrl,
                'ogImage' => $ogImage,
                'schemas' => $schemas,
            ],
        ]);
    }
}
