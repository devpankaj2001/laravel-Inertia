<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SchemaController extends Controller
{
    /**
     * Display the Schema & SEO configuration management center.
     */
    public function index()
    {
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
            'currencies_accepted' => 'USD, EUR, GBP, INR, AED',
            'area_served' => 'Worldwide (USA, Canada, UK, UAE, India, Australia)',
        ]);

        $organization = SiteSetting::get('schema_organization', [
            'name' => 'WebRanker',
            'legal_name' => 'WebRanker Digital Global Enterprise Ltd.',
            'alternate_name' => 'WebRanker SEO & Tech Labs',
            'founding_date' => '2020-01-15',
            'founder_name' => 'Alexander Reed',
            'logo_url' => 'asset/logo.svg',
            'customer_service_phone' => '+91 (141) 234-5678',
            'customer_service_email' => 'support@webranker.com',
            'social_links' => [
                'https://twitter.com/webranker',
                'https://linkedin.com/company/webranker',
                'https://facebook.com/webranker',
                'https://github.com/webranker',
            ],
        ]);

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

        $customJsonLdRaw = SiteSetting::where('key', 'schema_custom_jsonld')->value('value');
        if (! $customJsonLdRaw) {
            $customJsonLdRaw = json_encode([
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'SoftwareApplication',
                    'name' => 'WebRanker Core Performance Audit Engine',
                    'operatingSystem' => 'All Web Platforms',
                    'applicationCategory' => 'BusinessApplication',
                    'offers' => [
                        '@type' => 'Offer',
                        'price' => '0.00',
                        'priceCurrency' => 'USD',
                    ],
                ]
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }

        $toggles = SiteSetting::get('schema_toggles', [
            'enable_local_business' => true,
            'enable_organization' => true,
            'enable_website' => true,
            'enable_faq' => true,
            'enable_services' => true,
            'enable_custom_jsonld' => true,
        ]);

        return view('admin.schema.index', compact('localBusiness', 'organization', 'seo', 'customJsonLdRaw', 'toggles'));
    }

    /**
     * Update Schema & SEO configuration.
     */
    public function update(Request $request)
    {
        $section = $request->input('section', 'all');

        if ($section === 'local' || $section === 'all') {
            $localData = [
                'name' => $request->input('local_name', 'WebRanker Technologies HQ'),
                'legal_name' => $request->input('local_legal_name'),
                'image' => $request->input('local_image', 'asset/logo.svg'),
                'street_address' => $request->input('local_street_address'),
                'address_locality' => $request->input('local_address_locality'),
                'address_region' => $request->input('local_address_region'),
                'postal_code' => $request->input('local_postal_code'),
                'address_country' => $request->input('local_address_country', 'IN'),
                'telephone' => $request->input('local_telephone'),
                'email' => $request->input('local_email'),
                'latitude' => $request->input('local_latitude'),
                'longitude' => $request->input('local_longitude'),
                'price_range' => $request->input('local_price_range', '$$$'),
                'opening_hours' => $request->input('local_opening_hours', 'Mo-Fr 09:00-19:00'),
                'currencies_accepted' => $request->input('local_currencies_accepted'),
                'area_served' => $request->input('local_area_served'),
            ];
            SiteSetting::set('schema_local_business', $localData, 'json', 'seo');
        }

        if ($section === 'organization' || $section === 'all') {
            $socialLinks = array_filter(array_map('trim', explode("\n", (string) $request->input('org_social_links', ''))));
            $orgData = [
                'name' => $request->input('org_name', 'WebRanker'),
                'legal_name' => $request->input('org_legal_name'),
                'alternate_name' => $request->input('org_alternate_name'),
                'founding_date' => $request->input('org_founding_date'),
                'founder_name' => $request->input('org_founder_name'),
                'logo_url' => $request->input('org_logo_url', 'asset/logo.svg'),
                'customer_service_phone' => $request->input('org_customer_service_phone'),
                'customer_service_email' => $request->input('org_customer_service_email'),
                'social_links' => array_values($socialLinks),
            ];
            SiteSetting::set('schema_organization', $orgData, 'json', 'seo');
        }

        if ($section === 'seo' || $section === 'all') {
            $seoData = [
                'meta_title' => $request->input('seo_meta_title'),
                'meta_description' => $request->input('seo_meta_description'),
                'meta_keywords' => $request->input('seo_meta_keywords'),
                'og_title' => $request->input('seo_og_title'),
                'og_description' => $request->input('seo_og_description'),
                'og_image' => $request->input('seo_og_image', 'asset/logo.svg'),
                'twitter_handle' => $request->input('seo_twitter_handle', '@webranker'),
                'robots_directive' => $request->input('seo_robots_directive', 'index, follow'),
                'google_site_verification' => $request->input('seo_google_site_verification'),
                'bing_site_verification' => $request->input('seo_bing_site_verification'),
            ];
            SiteSetting::set('schema_seo', $seoData, 'json', 'seo');

            // Also synchronize primary settings for convenience
            if ($request->filled('seo_meta_title')) {
                SiteSetting::set('meta_title', $request->input('seo_meta_title'), 'text', 'seo');
            }
            if ($request->filled('seo_meta_description')) {
                SiteSetting::set('meta_description', $request->input('seo_meta_description'), 'text', 'seo');
            }
            if ($request->filled('seo_meta_keywords')) {
                SiteSetting::set('meta_keywords', $request->input('seo_meta_keywords'), 'text', 'seo');
            }
        }

        if ($section === 'custom' || $section === 'all') {
            $rawJson = $request->input('custom_jsonld');
            if (! empty(trim($rawJson))) {
                json_decode($rawJson);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return back()
                        ->withInput()
                        ->withErrors(['custom_jsonld' => 'Invalid JSON Syntax: ' . json_last_error_msg()]);
                }
            }
            SiteSetting::set('schema_custom_jsonld', $rawJson, 'json', 'seo');
        }

        if ($section === 'toggles' || $section === 'all') {
            $toggles = [
                'enable_local_business' => $request->boolean('enable_local_business'),
                'enable_organization' => $request->boolean('enable_organization'),
                'enable_website' => $request->boolean('enable_website'),
                'enable_faq' => $request->boolean('enable_faq'),
                'enable_services' => $request->boolean('enable_services'),
                'enable_custom_jsonld' => $request->boolean('enable_custom_jsonld'),
            ];
            SiteSetting::set('schema_toggles', $toggles, 'json', 'seo');
        }

        // Flush all schema-related caches
        Cache::flush();

        return redirect()->route('admin.schema.index')
            ->with('success', 'Schema & SEO settings successfully updated and published to the live site!');
    }
}
