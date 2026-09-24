<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * Display the official WebRanker Contact & Growth Consultation Page.
     */
    public function index(Request $request)
    {
        $services = Service::active()->select('id', 'title', 'slug', 'category')->get();

        $contactInfo = [
            'email' => config('site.email'),
            'phone' => config('site.phone'),
            'address' => config('site.address'),
            'hours' => config('site.timing'),
            'response_time' => '< 24 Hours Guaranteed',
            'support_email' => config('site.support_email'),
            'partnerships_email' => config('site.email'),
        ];

        $faqs = [
            [
                'question' => 'How soon will a senior strategist review my project?',
                'answer' => 'Every inquiry is routed directly to a principal technical SEO architect. You will receive an initial domain health assessment and scheduling confirmation within 24 business hours.',
            ],
            [
                'question' => 'Is our conversation and data protected by NDA?',
                'answer' => 'Absolutely. We treat all client search console data, pre-release domains, and commercial targets under strict non-disclosure obligations.',
            ],
            [
                'question' => 'What is included in the free preliminary growth audit?',
                'answer' => 'Our preliminary audit reviews Core Web Vitals (INP, LCP, CLS), indexing hurdles, technical schema hygiene, and top 3 organic revenue competitor keyword gaps.',
            ],
            [
                'question' => 'Do you work with international or remote engineering teams?',
                'answer' => 'Yes. Over 65% of our clients are based across the United States, UK, UAE, and Singapore with dedicated timezone-aligned communication channels.',
            ],
        ];

        // SEO Meta & Canonical Setup
        $metaTitle = "Contact Us | WebRanker - Enterprise SEO & Web Engineering Agency";
        $metaDescription = "Connect with WebRanker's senior SEO engineers and growth architects. Schedule a free organic audit, discuss custom web development, or request technical consulting.";
        $canonicalUrl = route('contact');

        $schemas = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'ContactPage',
                'name' => $metaTitle,
                'description' => $metaDescription,
                'url' => $canonicalUrl,
                'mainEntity' => [
                    '@type' => 'Organization',
                    'name' => 'WebRanker',
                    'url' => url('/'),
                    'contactPoint' => [
                        '@type' => 'ContactPoint',
                        'telephone' => $contactInfo['phone'],
                        'contactType' => 'customer support & enterprise sales',
                        'email' => $contactInfo['email'],
                        'availableLanguage' => ['English', 'Hindi'],
                    ],
                ],
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
                        'name' => 'Contact',
                        'item' => $canonicalUrl,
                    ],
                ],
            ],
        ];

        $contentHtml = view('contact_content', compact(
            'services',
            'contactInfo',
            'faqs',
            'metaTitle',
            'metaDescription',
            'canonicalUrl',
            'schemas'
        ))->render();

        return Inertia::render('Contact', [
            'contentHtml' => $contentHtml,
            'services' => $services,
            'contactInfo' => $contactInfo,
            'faqs' => $faqs,
            'seo' => [
                'metaTitle' => $metaTitle,
                'metaDescription' => $metaDescription,
                'canonicalUrl' => $canonicalUrl,
                'schemas' => $schemas,
            ],
        ]);
    }
}
