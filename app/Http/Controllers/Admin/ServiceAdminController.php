<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceAdminController extends Controller
{
    /**
     * Display a listing of services.
     */
    public function index(Request $request)
    {
        $categoryFilter = $request->query('category');
        $statusFilter = $request->query('status');
        $search = $request->query('search');

        $query = Service::query();

        if (!empty($categoryFilter)) {
            $query->where(function ($q) use ($categoryFilter) {
                $q->where('category', $categoryFilter)
                  ->orWhereJsonContains('categories', $categoryFilter);
            });
        }

        if ($statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('tagline', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $services = $query->orderBy('sort_order', 'asc')->orderBy('id', 'desc')->get();

        // Standard industry categories in alphabetical character order
        $categories = self::getStandardCategories();

        $categoryCounts = [];
        foreach ($categories as $cat) {
            $count = Service::where('category', $cat)
                ->orWhereJsonContains('categories', $cat)
                ->count();
            if ($count > 0) {
                $categoryCounts[$cat] = $count;
            }
        }

        $totalCount = Service::count();
        $activeCount = Service::where('is_active', true)->count();

        return view('admin.services.index', compact(
            'services',
            'categories',
            'categoryCounts',
            'totalCount',
            'activeCount',
            'categoryFilter',
            'statusFilter',
            'search'
        ));
    }

    /**
     * Get all available standard industry categories in alphabetical order.
     */
    public static function getStandardCategories(): array
    {
        $defaults = [
            'Automotive',
            'Design & Reliability',
            'E-commerce',
            'Education',
            'Engineering & Architecture',
            'FinTech',
            'Growth & Intelligence',
            'Healthcare',
            'Insurance',
            'Legal',
            'Logistics',
            'Real Estate',
            'Travel & Hospitality',
        ];

        $dbCategories = Service::select('category')->distinct()->pluck('category')->filter()->toArray();

        // Also extract from categories JSON column
        $servicesWithJson = Service::whereNotNull('categories')->pluck('categories');
        foreach ($servicesWithJson as $cats) {
            if (is_array($cats)) {
                $dbCategories = array_merge($dbCategories, $cats);
            }
        }

        $all = array_unique(array_filter(array_merge($defaults, $dbCategories)));
        natcasesort($all);
        return array_values($all);
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        $existingCategories = self::getStandardCategories();

        $defaultLocal = \App\Models\SiteSetting::get('schema_local_business', []);
        $defaultOrg = \App\Models\SiteSetting::get('schema_organization', []);

        return view('admin.services.create', compact('existingCategories', 'defaultLocal', 'defaultOrg'));
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug',
            'category_select' => 'nullable|string|max:255',
            'category_new' => 'nullable|string|max:255',
            'categories' => 'nullable|array',
            'categories.*' => 'nullable|string|max:255',
            'icon' => 'required|string|max:100',
            'tagline' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'badge' => 'nullable|string|max:100',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
            'kpi_label' => 'nullable|string|max:100',
            'kpi_value' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'focus_keywords' => 'nullable|string|max:255',
            'detailed_content' => 'nullable|string',
            'custom_schema' => 'nullable|string',
            'faq_questions' => 'nullable|array',
            'faq_answers' => 'nullable|array',
            // Local Schema
            'local_name' => 'nullable|string|max:255',
            'local_telephone' => 'nullable|string|max:100',
            'local_email' => 'nullable|string|max:255',
            'local_address' => 'nullable|string|max:255',
            'local_locality' => 'nullable|string|max:100',
            'local_region' => 'nullable|string|max:100',
            'local_postal_code' => 'nullable|string|max:50',
            'local_country' => 'nullable|string|max:10',
            'local_latitude' => 'nullable|string|max:50',
            'local_longitude' => 'nullable|string|max:50',
            'local_price_range' => 'nullable|string|max:20',
            'local_opening_hours' => 'nullable|string|max:100',
            // Business Schema
            'biz_name' => 'nullable|string|max:255',
            'biz_legal_name' => 'nullable|string|max:255',
            'biz_logo_url' => 'nullable|string|max:255',
            'biz_phone' => 'nullable|string|max:100',
            'biz_email' => 'nullable|string|max:255',
            'biz_social_links' => 'nullable|string',
        ]);

        // Resolve categories list (supporting multiple category selection via checkboxes)
        $selectedCategories = [];
        if ($request->has('categories') && is_array($request->input('categories'))) {
            $selectedCategories = array_values(array_filter(array_map('trim', $request->input('categories'))));
        }

        // If category_new is filled, append it
        if ($request->filled('category_new')) {
            $newCat = trim($request->input('category_new'));
            if (!empty($newCat) && !in_array($newCat, $selectedCategories)) {
                $selectedCategories[] = $newCat;
            }
        }

        // Fallback if legacy category_select was sent
        if ($request->filled('category_select')) {
            $selCat = trim($request->input('category_select'));
            if (!empty($selCat) && !in_array($selCat, $selectedCategories)) {
                $selectedCategories[] = $selCat;
            }
        }

        if (empty($selectedCategories)) {
            return back()->withInput()->withErrors(['categories' => 'Please select at least one category or enter a new one.']);
        }

        $primaryCategory = $selectedCategories[0];

        // Generate slug if not provided
        $slug = $request->filled('slug')
            ? Str::slug($request->input('slug'))
            : Str::slug($request->input('title'));

        // Ensure unique slug
        $baseSlug = $slug;
        $counter = 1;
        while (Service::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        // Clean features array
        $features = collect($request->input('features', []))
            ->map(fn ($item) => trim((string) $item))
            ->filter(fn ($item) => !empty($item))
            ->values()
            ->toArray();

        // Process dynamic FAQs
        $faqQuestions = $request->input('faq_questions', []);
        $faqAnswers = $request->input('faq_answers', []);
        $faqs = [];
        if (is_array($faqQuestions) && is_array($faqAnswers)) {
            foreach ($faqQuestions as $fIdx => $question) {
                $q = trim((string) $question);
                $a = trim((string) ($faqAnswers[$fIdx] ?? ''));
                if (!empty($q) && !empty($a)) {
                    $faqs[] = ['question' => $q, 'answer' => $a];
                }
            }
        }

        // Process LocalBusiness Schema
        $localSchema = null;
        $localKeys = ['local_name', 'local_telephone', 'local_email', 'local_address', 'local_locality', 'local_region', 'local_postal_code', 'local_latitude', 'local_longitude'];
        $hasLocal = collect($localKeys)->contains(fn ($key) => $request->filled($key));
        if ($hasLocal) {
            $localSchema = [
                'name' => $request->input('local_name'),
                'telephone' => $request->input('local_telephone'),
                'email' => $request->input('local_email'),
                'street_address' => $request->input('local_address'),
                'address_locality' => $request->input('local_locality'),
                'address_region' => $request->input('local_region'),
                'postal_code' => $request->input('local_postal_code'),
                'address_country' => $request->input('local_country', 'IN'),
                'latitude' => $request->input('local_latitude'),
                'longitude' => $request->input('local_longitude'),
                'price_range' => $request->input('local_price_range', '$$$'),
                'opening_hours' => $request->input('local_opening_hours', 'Mo-Fr 09:00-19:00'),
            ];
        }

        // Process Business / Organization Schema
        $businessSchema = null;
        $bizKeys = ['biz_name', 'biz_legal_name', 'biz_logo_url', 'biz_phone', 'biz_email', 'biz_social_links'];
        $hasBiz = collect($bizKeys)->contains(fn ($key) => $request->filled($key));
        if ($hasBiz) {
            $socialLinks = array_filter(array_map('trim', explode("\n", (string) $request->input('biz_social_links', ''))));
            $businessSchema = [
                'name' => $request->input('biz_name'),
                'legal_name' => $request->input('biz_legal_name'),
                'logo_url' => $request->input('biz_logo_url'),
                'customer_service_phone' => $request->input('biz_phone'),
                'customer_service_email' => $request->input('biz_email'),
                'telephone' => $request->input('biz_phone'),
                'email' => $request->input('biz_email'),
                'social_links' => array_values($socialLinks),
            ];
        }

        Service::create([
            'title' => $request->input('title'),
            'slug' => $slug,
            'category' => $primaryCategory,
            'categories' => $selectedCategories,
            'icon' => $request->input('icon', 'fa-solid fa-cube'),
            'tagline' => $request->input('tagline'),
            'short_description' => $request->input('short_description'),
            'detailed_content' => $request->input('detailed_content'),
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'focus_keywords' => $request->input('focus_keywords'),
            'badge' => $request->input('badge'),
            'features' => $features,
            'faqs' => $faqs,
            'local_schema' => $localSchema,
            'business_schema' => $businessSchema,
            'custom_schema' => $request->input('custom_schema'),
            'kpi_label' => $request->input('kpi_label'),
            'kpi_value' => $request->input('kpi_value'),
            'sort_order' => (int) ($request->input('sort_order') ?? 0),
            'is_featured' => $request->boolean('is_featured', true),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', "Service '{$request->input('title')}' in category '{$primaryCategory}' has been created successfully.");
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service)
    {
        $existingCategories = self::getStandardCategories();

        $defaultLocal = \App\Models\SiteSetting::get('schema_local_business', []);
        $defaultOrg = \App\Models\SiteSetting::get('schema_organization', []);

        return view('admin.services.edit', compact('service', 'existingCategories', 'defaultLocal', 'defaultOrg'));
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => "nullable|string|max:255|unique:services,slug,{$service->id}",
            'category_select' => 'nullable|string|max:255',
            'category_new' => 'nullable|string|max:255',
            'categories' => 'nullable|array',
            'categories.*' => 'nullable|string|max:255',
            'icon' => 'required|string|max:100',
            'tagline' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'badge' => 'nullable|string|max:100',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
            'kpi_label' => 'nullable|string|max:100',
            'kpi_value' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'focus_keywords' => 'nullable|string|max:255',
            'detailed_content' => 'nullable|string',
            'custom_schema' => 'nullable|string',
            'faq_questions' => 'nullable|array',
            'faq_answers' => 'nullable|array',
            // Local Schema
            'local_name' => 'nullable|string|max:255',
            'local_telephone' => 'nullable|string|max:100',
            'local_email' => 'nullable|string|max:255',
            'local_address' => 'nullable|string|max:255',
            'local_locality' => 'nullable|string|max:100',
            'local_region' => 'nullable|string|max:100',
            'local_postal_code' => 'nullable|string|max:50',
            'local_country' => 'nullable|string|max:10',
            'local_latitude' => 'nullable|string|max:50',
            'local_longitude' => 'nullable|string|max:50',
            'local_price_range' => 'nullable|string|max:20',
            'local_opening_hours' => 'nullable|string|max:100',
            // Business Schema
            'biz_name' => 'nullable|string|max:255',
            'biz_legal_name' => 'nullable|string|max:255',
            'biz_logo_url' => 'nullable|string|max:255',
            'biz_phone' => 'nullable|string|max:100',
            'biz_email' => 'nullable|string|max:255',
            'biz_social_links' => 'nullable|string',
        ]);

        // Resolve categories list (supporting multiple category selection via checkboxes)
        $selectedCategories = [];
        if ($request->has('categories') && is_array($request->input('categories'))) {
            $selectedCategories = array_values(array_filter(array_map('trim', $request->input('categories'))));
        }

        if ($request->filled('category_new')) {
            $newCat = trim($request->input('category_new'));
            if (!empty($newCat) && !in_array($newCat, $selectedCategories)) {
                $selectedCategories[] = $newCat;
            }
        }

        if ($request->filled('category_select')) {
            $selCat = trim($request->input('category_select'));
            if (!empty($selCat) && !in_array($selCat, $selectedCategories)) {
                $selectedCategories[] = $selCat;
            }
        }

        if (empty($selectedCategories)) {
            return back()->withInput()->withErrors(['categories' => 'Please select at least one category or enter a new one.']);
        }

        $primaryCategory = $selectedCategories[0];

        // Slug
        $slug = $request->filled('slug')
            ? Str::slug($request->input('slug'))
            : Str::slug($request->input('title'));

        // Clean features
        $features = collect($request->input('features', []))
            ->map(fn ($item) => trim((string) $item))
            ->filter(fn ($item) => !empty($item))
            ->values()
            ->toArray();

        // Process dynamic FAQs
        $faqQuestions = $request->input('faq_questions', []);
        $faqAnswers = $request->input('faq_answers', []);
        $faqs = [];
        if (is_array($faqQuestions) && is_array($faqAnswers)) {
            foreach ($faqQuestions as $fIdx => $question) {
                $q = trim((string) $question);
                $a = trim((string) ($faqAnswers[$fIdx] ?? ''));
                if (!empty($q) && !empty($a)) {
                    $faqs[] = ['question' => $q, 'answer' => $a];
                }
            }
        }

        // Process LocalBusiness Schema
        $localSchema = null;
        $localKeys = ['local_name', 'local_telephone', 'local_email', 'local_address', 'local_locality', 'local_region', 'local_postal_code', 'local_latitude', 'local_longitude'];
        $hasLocal = collect($localKeys)->contains(fn ($key) => $request->filled($key));
        if ($hasLocal) {
            $localSchema = [
                'name' => $request->input('local_name'),
                'telephone' => $request->input('local_telephone'),
                'email' => $request->input('local_email'),
                'street_address' => $request->input('local_address'),
                'address_locality' => $request->input('local_locality'),
                'address_region' => $request->input('local_region'),
                'postal_code' => $request->input('local_postal_code'),
                'address_country' => $request->input('local_country', 'IN'),
                'latitude' => $request->input('local_latitude'),
                'longitude' => $request->input('local_longitude'),
                'price_range' => $request->input('local_price_range', '$$$'),
                'opening_hours' => $request->input('local_opening_hours', 'Mo-Fr 09:00-19:00'),
            ];
        }

        // Process Business / Organization Schema
        $businessSchema = null;
        $bizKeys = ['biz_name', 'biz_legal_name', 'biz_logo_url', 'biz_phone', 'biz_email', 'biz_social_links'];
        $hasBiz = collect($bizKeys)->contains(fn ($key) => $request->filled($key));
        if ($hasBiz) {
            $socialLinks = array_filter(array_map('trim', explode("\n", (string) $request->input('biz_social_links', ''))));
            $businessSchema = [
                'name' => $request->input('biz_name'),
                'legal_name' => $request->input('biz_legal_name'),
                'logo_url' => $request->input('biz_logo_url'),
                'customer_service_phone' => $request->input('biz_phone'),
                'customer_service_email' => $request->input('biz_email'),
                'telephone' => $request->input('biz_phone'),
                'email' => $request->input('biz_email'),
                'social_links' => array_values($socialLinks),
            ];
        }

        $service->update([
            'title' => $request->input('title'),
            'slug' => $slug,
            'category' => $primaryCategory,
            'categories' => $selectedCategories,
            'icon' => $request->input('icon'),
            'tagline' => $request->input('tagline'),
            'short_description' => $request->input('short_description'),
            'detailed_content' => $request->input('detailed_content'),
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'focus_keywords' => $request->input('focus_keywords'),
            'badge' => $request->input('badge'),
            'features' => $features,
            'faqs' => $faqs,
            'local_schema' => $localSchema,
            'business_schema' => $businessSchema,
            'custom_schema' => $request->input('custom_schema'),
            'kpi_label' => $request->input('kpi_label'),
            'kpi_value' => $request->input('kpi_value'),
            'sort_order' => (int) ($request->input('sort_order') ?? 0),
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', "Service '{$service->title}' has been updated successfully.");
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Service $service)
    {
        $title = $service->title;
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', "Service '{$title}' has been deleted.");
    }

    /**
     * Toggle active status of a service.
     */
    public function toggle(Service $service)
    {
        $service->is_active = !$service->is_active;
        $service->save();

        $status = $service->is_active ? 'activated' : 'deactivated';

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $service->is_active,
                'message' => "Service '{$service->title}' {$status}."
            ]);
        }

        return redirect()->back()->with('success', "Service '{$service->title}' has been {$status}.");
    }

    /**
     * Overview of dynamic categories and services assigned to them.
     */
    public function categories()
    {
        $categories = self::getStandardCategories();

        $allServices = Service::orderBy('sort_order', 'asc')->get();
        $servicesGrouped = collect();
        foreach ($allServices as $svc) {
            foreach ($svc->all_categories as $cat) {
                if (!$servicesGrouped->has($cat)) {
                    $servicesGrouped->put($cat, collect());
                }
                $servicesGrouped->get($cat)->push($svc);
            }
        }

        return view('admin.services.categories', compact('categories', 'servicesGrouped'));
    }

    /**
     * Bulk-rename a category across all services.
     */
    public function updateCategory(Request $request)
    {
        $request->validate([
            'old_category' => 'required|string',
            'new_category' => 'required|string|max:255',
        ]);

        $oldCategory = trim($request->input('old_category'));
        $newCategory = trim($request->input('new_category'));

        $count = Service::where('category', $oldCategory)->update(['category' => $newCategory]);

        return redirect()->back()
            ->with('success', "Renamed category '{$oldCategory}' to '{$newCategory}' across {$count} service(s).");
    }
}
