<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Faq;
use App\Models\IndustryDomain;
use App\Models\Inquiry;
use App\Models\Service;
use App\Models\SiteSetting;

class DashboardController extends Controller
{
    /**
     * Display admin overview dashboard.
     */
    public function index()
    {
        $stats = [
            'total_inquiries' => Inquiry::count(),
            'new_inquiries' => Inquiry::where('status', 'new')->count(),
            'total_services' => Service::count(),
            'total_domains' => IndustryDomain::count(),
            'total_faqs' => Faq::count(),
            'total_blogs' => BlogPost::count(),
        ];

        $recentInquiries = Inquiry::latest()->take(5)->get();
        $schemaToggles = SiteSetting::get('schema_toggles', [
            'enable_local_business' => true,
            'enable_organization' => true,
            'enable_website' => true,
            'enable_faq' => true,
            'enable_services' => true,
            'enable_custom_jsonld' => true,
        ]);

        return view('admin.dashboard', compact('stats', 'recentInquiries', 'schemaToggles'));
    }
}
