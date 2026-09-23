<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomePageController extends Controller
{
    /**
     * Display the Home Page dynamic content & Schema JSON-LD manager.
     */
    public function index()
    {
        // 1. Dynamic Hero & Content Settings
        $heroContent = [
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

        // 2. Local Business Schema (Jaipur HQ / Local SEO)
        $localBusiness = SiteSetting::get('schema_local_business', [
            'name' => 'WebRanker Technologies HQ',
            'legal_name' => 'WebRanker Digital & Engineering Solutions Pvt. Ltd.',
            'image' => 'asset/logo.svg',
            'street_address' => 'Plot no. 51, Shaheed Amit Bhardwaj Marg, opp. 8/1, Sector 8, Malviya Nagar, Jaipur, Rajasthan 302017',
            'address_locality' => 'Jaipur',
            'address_region' => 'Rajasthan',
            'postal_code' => '302017',
            'address_country' => 'IN',
            'telephone' => '+91 97185 70218',
            'email' => 'growth@webranker.com',
            'latitude' => '26.844394',
            'longitude' => '75.805302',
            'price_range' => '$$$',
            'opening_hours' => 'Mo-Fr 09:00-19:00',
            'currencies_accepted' => 'INR',
            'area_served' => 'Jaipur, Rajasthan, India',
        ]);

        // 3. Organization & Corporate Business Schema
        $organization = SiteSetting::get('schema_organization', [
            'name' => 'WebRanker',
            'legal_name' => 'WebRanker Digital Global Enterprise Ltd.',
            'alternate_name' => 'WebRanker SEO & Tech Labs',
            'founding_date' => '2020-01-15',
            'founder_name' => 'Alexander Reed',
            'logo_url' => 'asset/logo.svg',
            'customer_service_phone' => '+91 97185 70218',
            'customer_service_email' => 'support@webranker.com',
            'social_links' => [
                'https://twitter.com/webranker',
                'https://linkedin.com/company/webranker',
                'https://facebook.com/webranker',
                'https://github.com/webranker',
            ],
        ]);

        // 4. Custom JSON-LD Schema
        $customJsonLdRaw = SiteSetting::where('key', 'schema_custom_jsonld')->value('value');
        if (! $customJsonLdRaw) {
            $customJsonLdRaw = json_encode([
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'ProfessionalService',
                    'name' => 'WebRanker Search & Web Engineering',
                    'image' => asset('asset/logo.svg'),
                    'priceRange' => '$$$',
                    'telephone' => '+91 97185 70218',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => 'Plot no. 51, Shaheed Amit Bhardwaj Marg, opp. 8/1, Sector 8, Malviya Nagar',
                        'addressLocality' => 'Jaipur',
                        'addressRegion' => 'Rajasthan',
                        'postalCode' => '302017',
                        'addressCountry' => 'IN'
                    ],
                    'aggregateRating' => [
                        '@type' => 'AggregateRating',
                        'ratingValue' => '4.9',
                        'reviewCount' => '142',
                        'bestRating' => '5',
                        'worstRating' => '1'
                    ]
                ]
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }

        // 5. SEO & Meta Tags
        $seo = SiteSetting::get('schema_seo', [
            'meta_title' => 'WebRanker | Web & App Development, SEO, Content & Performance Optimization',
            'meta_description' => 'WebRanker is an elite engineering and organic search agency specializing in Web Development, Mobile Apps, Technical SEO, Topical Content, and Site Speed Optimization.',
            'meta_keywords' => 'web development, mobile app development, technical SEO, organic search ranking, site speed optimization, core web vitals',
            'og_title' => 'WebRanker | Top #1 Organic Growth & Engineering',
            'og_description' => 'Turn search traffic into revenue with sub-second web performance, custom app architectures, and high-impact SEO.',
            'og_image' => 'asset/logo.svg',
            'twitter_handle' => '@webranker',
            'robots_directive' => 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
            'google_site_verification' => '',
            'bing_site_verification' => '',
        ]);

        // 6. Schema Toggles
        $toggles = SiteSetting::get('schema_toggles', [
            'enable_local_business' => true,
            'enable_organization' => true,
            'enable_website' => true,
            'enable_faq' => true,
            'enable_services' => true,
            'enable_custom_jsonld' => true,
        ]);

        return view('admin.homepage.index', compact('heroContent', 'localBusiness', 'organization', 'customJsonLdRaw', 'seo', 'toggles'));
    }

    /**
     * Update Home Page dynamic content & Schema JSON-LD configurations.
     */
    public function update(Request $request)
    {
        $section = $request->input('section', 'content');

        if ($section === 'content') {
            // Dynamic Hero & Proof Content
            SiteSetting::set('home_hero_kicker', $request->input('kicker', 'SEO, Web Design & Digital Marketing'), 'text', 'homepage');
            SiteSetting::set('home_hero_title', $request->input('title', 'Smooth and grow your business.'), 'text', 'homepage');
            SiteSetting::set('home_hero_title_accent', $request->input('title_accent', 'From search to sales.'), 'text', 'homepage');
            SiteSetting::set('home_hero_lead', $request->input('lead', ''), 'text', 'homepage');
            SiteSetting::set('home_hero_cta_text', $request->input('cta_text', 'Claim Free Growth Audit'), 'text', 'homepage');
            SiteSetting::set('home_hero_cta_link', $request->input('cta_link', '#consultation'), 'text', 'homepage');
            SiteSetting::set('home_hero_secondary_text', $request->input('secondary_text', 'See our services'), 'text', 'homepage');
            SiteSetting::set('home_hero_secondary_link', $request->input('secondary_link', '#services'), 'text', 'homepage');
            SiteSetting::set('home_hero_serp_badge', $request->input('serp_badge', 'LIVE SERP POSITION #1'), 'text', 'homepage');
            SiteSetting::set('home_hero_serp_sub', $request->input('serp_sub', '+318% organic traffic'), 'text', 'homepage');

            $labels = $request->input('proof_labels', []);
            $descs = $request->input('proof_descs', []);
            $proofTags = [];
            foreach ($labels as $idx => $lbl) {
                if (!empty(trim($lbl))) {
                    $proofTags[] = [
                        'label' => trim($lbl),
                        'desc' => $descs[$idx] ?? '',
                    ];
                }
            }
            if (!empty($proofTags)) {
                SiteSetting::set('home_proof_tags', $proofTags, 'json', 'homepage');
            }

            return redirect()->route('admin.homepage.index', ['tab' => 'content'])->with('success', 'Home Page content successfully updated!');
        }

        if ($section === 'local') {
            // Local Business Schema JSON-LD
            $local = [
                'name' => $request->input('local_name', 'WebRanker Technologies HQ'),
                'legal_name' => $request->input('local_legal_name', 'WebRanker Digital & Engineering Solutions Pvt. Ltd.'),
                'image' => $request->input('local_image', 'asset/logo.svg'),
                'street_address' => $request->input('local_street_address', ''),
                'address_locality' => $request->input('local_address_locality', 'Jaipur'),
                'address_region' => $request->input('local_address_region', 'Rajasthan'),
                'postal_code' => $request->input('local_postal_code', '302017'),
                'address_country' => $request->input('local_address_country', 'IN'),
                'telephone' => $request->input('local_telephone', '+91 97185 70218'),
                'email' => $request->input('local_email', 'growth@webranker.com'),
                'latitude' => $request->input('local_latitude', '26.844394'),
                'longitude' => $request->input('local_longitude', '75.805302'),
                'price_range' => $request->input('local_price_range', '$$$'),
                'opening_hours' => $request->input('local_opening_hours', 'Mo-Fr 09:00-19:00'),
                'currencies_accepted' => $request->input('local_currencies_accepted', 'USD, INR, EUR'),
                'area_served' => $request->input('local_area_served', 'Worldwide'),
            ];

            SiteSetting::set('schema_local_business', $local, 'json', 'schema');

            return redirect()->route('admin.homepage.index', ['tab' => 'local'])->with('success', 'Local Business Schema JSON-LD updated successfully!');
        }

        if ($section === 'business') {
            // Business & Organization Schema JSON-LD
            $rawSocial = $request->input('org_social_links', '');
            $socialArray = array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $rawSocial)))));

            $org = [
                'name' => $request->input('org_name', 'WebRanker'),
                'legal_name' => $request->input('org_legal_name', ''),
                'alternate_name' => $request->input('org_alternate_name', ''),
                'founding_date' => $request->input('org_founding_date', '2020-01-15'),
                'founder_name' => $request->input('org_founder_name', 'Alexander Reed'),
                'logo_url' => $request->input('org_logo_url', 'asset/logo.svg'),
                'customer_service_phone' => $request->input('org_phone', '+91 97185 70218'),
                'customer_service_email' => $request->input('org_email', 'support@webranker.com'),
                'social_links' => $socialArray,
            ];

            SiteSetting::set('schema_organization', $org, 'json', 'schema');

            return redirect()->route('admin.homepage.index', ['tab' => 'business'])->with('success', 'Business / Organization Schema JSON-LD updated successfully!');
        }

        if ($section === 'custom') {
            // Custom JSON-LD Schema
            $jsonInput = trim($request->input('custom_jsonld', ''));

            if (!empty($jsonInput)) {
                $decoded = json_decode($jsonInput, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return redirect()->route('admin.homepage.index', ['tab' => 'custom'])
                        ->withErrors(['custom_jsonld' => 'Invalid JSON Syntax: ' . json_last_error_msg()])
                        ->withInput();
                }
                $jsonInput = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }

            SiteSetting::set('schema_custom_jsonld', $jsonInput, 'text', 'schema');

            return redirect()->route('admin.homepage.index', ['tab' => 'custom'])->with('success', 'Custom JSON-LD Schema successfully validated and saved!');
        }

        if ($section === 'seo') {
            // SEO & Meta Configuration
            $seo = [
                'meta_title' => $request->input('meta_title', ''),
                'meta_description' => $request->input('meta_description', ''),
                'meta_keywords' => $request->input('meta_keywords', ''),
                'og_title' => $request->input('og_title', ''),
                'og_description' => $request->input('og_description', ''),
                'og_image' => $request->input('og_image', 'asset/logo.svg'),
                'twitter_handle' => $request->input('twitter_handle', '@webranker'),
                'robots_directive' => $request->input('robots_directive', 'index, follow, max-image-preview:large'),
                'google_site_verification' => $request->input('google_site_verification', ''),
                'bing_site_verification' => $request->input('bing_site_verification', ''),
            ];

            SiteSetting::set('schema_seo', $seo, 'json', 'seo');

            return redirect()->route('admin.homepage.index', ['tab' => 'seo'])->with('success', 'Home Page SEO & Meta Tags updated successfully!');
        }

        if ($section === 'toggles') {
            // Schema Toggles
            $toggles = [
                'enable_local_business' => $request->boolean('enable_local_business'),
                'enable_organization' => $request->boolean('enable_organization'),
                'enable_website' => $request->boolean('enable_website'),
                'enable_faq' => $request->boolean('enable_faq'),
                'enable_services' => $request->boolean('enable_services'),
                'enable_custom_jsonld' => $request->boolean('enable_custom_jsonld'),
            ];

            SiteSetting::set('schema_toggles', $toggles, 'json', 'schema');

            return redirect()->route('admin.homepage.index', ['tab' => 'toggles'])->with('success', 'Schema active modules successfully updated!');
        }

        return redirect()->route('admin.homepage.index')->with('success', 'Settings updated successfully!');
    }
}
