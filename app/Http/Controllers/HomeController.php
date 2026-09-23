<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Faq;
use App\Models\IndustryDomain;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the dynamic, SEO-optimized home page.
     */
    public function index(Request $request)
    {
        // 1. Fetch Dynamic Data
        $services = Service::active()->get();
        $priorityOrder = [
            'Engineering & Architecture',
            'Growth & Intelligence',
            'Design & Reliability',
        ];
        $grouped = $services->groupBy('category');
        $servicesByCategory = collect();
        foreach ($priorityOrder as $catName) {
            if ($grouped->has($catName)) {
                $servicesByCategory->put($catName, $grouped->get($catName));
            }
        }
        foreach ($grouped as $catName => $items) {
            if (!$servicesByCategory->has($catName)) {
                $servicesByCategory->put($catName, $items);
            }
        }
        $industryDomains = IndustryDomain::active()->get();
        $testimonials = Testimonial::featured()->get();
        $faqs = Faq::active()->get();
        $blogs = BlogPost::published()->take(6)->get();

        // 2. Dynamic Home Page Content from Admin Panel
        $homeContent = [
            'kicker' => SiteSetting::get('home_hero_kicker', 'SEO, Web Design & Digital Marketing'),
            'title' => SiteSetting::get('home_hero_title', 'Smooth and grow your business.'),
            'title_accent' => SiteSetting::get('home_hero_title_accent', 'From search to sales.'),
            'lead' => SiteSetting::get('home_hero_lead', 'WebRanker is a results-driven digital agency. We design fast, conversion-ready websites and grow brands with SEO, PPC, social, content, and email — so you rank higher, attract the right traffic, and convert it into revenue.'),
            'cta_text' => SiteSetting::get('home_hero_cta_text', 'Claim Free Growth Audit'),
            'cta_link' => SiteSetting::get('home_hero_cta_link', '#consultation'),
            'secondary_text' => SiteSetting::get('home_hero_secondary_text', 'See our services'),
            'secondary_link' => SiteSetting::get('home_hero_secondary_link', '#services'),
            'serp_badge' => SiteSetting::get('home_hero_serp_badge', 'LIVE SERP POSITION #1'),
            'serp_sub' => SiteSetting::get('home_hero_serp_sub', '+318% organic traffic'),
            'proof_tags' => SiteSetting::get('home_proof_tags', [
                ['label' => 'SEO', 'desc' => 'Organic rankings'],
                ['label' => 'Web', 'desc' => 'Design & build'],
                ['label' => 'PPC', 'desc' => 'Paid growth'],
                ['label' => 'SMO', 'desc' => 'Social presence'],
            ]),
        ];

        // 3. SEO & Schema Settings from Admin Panel
        $seoSettings = SiteSetting::get('schema_seo', []);
        $localSettings = SiteSetting::get('schema_local_business', []);
        $orgSettings = SiteSetting::get('schema_organization', []);
        $toggles = SiteSetting::get('schema_toggles', [
            'enable_local_business' => true,
            'enable_organization' => true,
            'enable_website' => true,
            'enable_faq' => true,
            'enable_services' => true,
            'enable_custom_jsonld' => true,
        ]);

        $siteName = $seoSettings['meta_title'] ?? SiteSetting::get('site_name', 'WebRanker');
        $metaTitle = $seoSettings['meta_title'] ?? SiteSetting::get('meta_title', 'WebRanker | Web & App Development, SEO, Content & Performance Optimization');
        $metaDescription = $seoSettings['meta_description'] ?? SiteSetting::get('meta_description', 'WebRanker is an elite engineering and organic search agency specializing in Web Development, Mobile Apps, Technical SEO, Topical Content, and Site Speed Optimization.');
        $metaKeywords = $seoSettings['meta_keywords'] ?? SiteSetting::get('meta_keywords', 'web development, mobile app development, technical SEO, core web vitals, ecommerce development, AI automation');
        $ogImage = asset($seoSettings['og_image'] ?? SiteSetting::get('og_image', 'asset/logo.svg'));
        $canonicalUrl = url()->current();
        $googleVerification = $seoSettings['google_site_verification'] ?? SiteSetting::get('google_site_verification');
        $bingVerification = $seoSettings['bing_site_verification'] ?? SiteSetting::get('bing_site_verification');

        // 3. Generate Schema.org JSON-LD Structured Data
        $schemas = [];

        // Organization & Brand Schema
        if ($toggles['enable_organization'] ?? true) {
            $schemas[] = [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                '@id' => url('/') . '/#organization',
                'name' => $orgSettings['name'] ?? 'WebRanker',
                'legalName' => $orgSettings['legal_name'] ?? 'WebRanker Digital Global Enterprise Ltd.',
                'alternateName' => $orgSettings['alternate_name'] ?? 'WebRanker SEO & Tech Labs',
                'url' => url('/'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset($orgSettings['logo_url'] ?? 'asset/logo.svg'),
                ],
                'sameAs' => array_values(array_filter($orgSettings['social_links'] ?? [
                    SiteSetting::get('social_twitter'),
                    SiteSetting::get('social_linkedin'),
                    SiteSetting::get('social_github'),
                ])),
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'telephone' => $orgSettings['customer_service_phone'] ?? SiteSetting::get('contact_phone', '+91 (141) 234-5678'),
                    'contactType' => 'customer service',
                    'email' => $orgSettings['customer_service_email'] ?? SiteSetting::get('contact_email', 'growth@webranker.com'),
                    'areaServed' => 'Worldwide',
                    'availableLanguage' => ['English'],
                ],
            ];
        }

        // WebSite with Sitelinks Searchbox
        if ($toggles['enable_website'] ?? true) {
            $schemas[] = [
                '@context' => 'https://schema.org',
                '@type' => 'WebSite',
                '@id' => url('/') . '/#website',
                'url' => url('/'),
                'name' => $siteName,
                'description' => $metaDescription,
                'publisher' => [
                    '@id' => url('/') . '/#organization',
                ],
                'potentialAction' => [
                    '@type' => 'SearchAction',
                    'target' => url('/') . '/?s={search_term_string}',
                    'query-input' => 'required name=search_term_string',
                ],
            ];
        }

        // LocalBusiness / ProfessionalService Schema
        if ($toggles['enable_local_business'] ?? true) {
            $schemas[] = [
                '@context' => 'https://schema.org',
                '@type' => ['ProfessionalService', 'LocalBusiness'],
                '@id' => url('/') . '/#localbusiness',
                'name' => $localSettings['name'] ?? 'WebRanker Technologies HQ',
                'legalName' => $localSettings['legal_name'] ?? 'WebRanker Digital & Engineering Solutions Pvt. Ltd.',
                'image' => asset($localSettings['image'] ?? 'asset/logo.svg'),
                'telephone' => $localSettings['telephone'] ?? SiteSetting::get('contact_phone', '+91 (141) 234-5678'),
                'email' => $localSettings['email'] ?? SiteSetting::get('contact_email', 'growth@webranker.com'),
                'priceRange' => $localSettings['price_range'] ?? '$$$',
                'currenciesAccepted' => $localSettings['currencies_accepted'] ?? 'USD, EUR, GBP, INR',
                'areaServed' => $localSettings['area_served'] ?? 'Worldwide',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $localSettings['street_address'] ?? 'Plot No. 4, IT Park, Malviya Nagar',
                    'addressLocality' => $localSettings['address_locality'] ?? 'Jaipur',
                    'addressRegion' => $localSettings['address_region'] ?? 'Rajasthan',
                    'postalCode' => $localSettings['postal_code'] ?? '302017',
                    'addressCountry' => $localSettings['address_country'] ?? 'IN',
                ],
                'geo' => [
                    '@type' => 'GeoCoordinates',
                    'latitude' => (float) ($localSettings['latitude'] ?? 26.8530),
                    'longitude' => (float) ($localSettings['longitude'] ?? 75.8050),
                ],
                'openingHoursSpecification' => [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                    'opens' => '09:00',
                    'closes' => '19:00',
                ],
            ];
        }

        // FAQPage Schema (for Google FAQ Rich Snippets)
        if (($toggles['enable_faq'] ?? true) && $faqs->isNotEmpty()) {
            $schemas[] = [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => $faqs->map(function ($faq) {
                    return [
                        '@type' => 'Question',
                        'name' => $faq->question,
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => $faq->answer,
                        ],
                    ];
                })->toArray(),
            ];
        }

        // Service Offerings ItemList Schema
        if (($toggles['enable_services'] ?? true) && $services->isNotEmpty()) {
            $schemas[] = [
                '@context' => 'https://schema.org',
                '@type' => 'ItemList',
                'itemListElement' => $services->map(function ($svc, $idx) {
                    return [
                        '@type' => 'ListItem',
                        'position' => $idx + 1,
                        'item' => [
                            '@type' => 'Service',
                            'name' => $svc->title,
                            'description' => $svc->short_description,
                            'provider' => [
                                '@id' => url('/') . '/#organization',
                            ],
                        ],
                    ];
                })->toArray(),
            ];
        }

        // Custom Raw JSON-LD Schema (from Admin Panel)
        $customJsonLd = null;
        if ($toggles['enable_custom_jsonld'] ?? true) {
            $rawCustom = SiteSetting::where('key', 'schema_custom_jsonld')->value('value');
            if (! empty(trim((string) $rawCustom))) {
                $decoded = json_decode($rawCustom, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $customJsonLd = $decoded;
                }
            }
        }

        return view('home', compact(
            'services',
            'servicesByCategory',
            'industryDomains',
            'testimonials',
            'faqs',
            'blogs',
            'metaTitle',
            'metaDescription',
            'metaKeywords',
            'canonicalUrl',
            'ogImage',
            'googleVerification',
            'bingVerification',
            'schemas',
            'customJsonLd',
            'homeContent'
        ));
    }
}
