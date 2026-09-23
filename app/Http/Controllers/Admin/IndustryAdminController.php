<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IndustryDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IndustryAdminController extends Controller
{
    /**
     * Standard category groups for organizing industries.
     */
    public static function getCategoryGroups(): array
    {
        return [
            'Finance & Commerce',
            'Health & Life Sciences',
            'Enterprise, SaaS & Tech',
            'Mobility & Logistics',
            'Legal, Public & Professional',
            'Consumer, Media & Lifestyle',
        ];
    }

    /**
     * Display a listing of industries.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $group = $request->query('group');

        $query = IndustryDomain::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category_group', 'like', "%{$search}%");
            });
        }

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        if (!empty($group) && $group !== 'all') {
            $query->where('category_group', $group);
        }

        $industries = $query->orderBy('sort_order', 'asc')->orderBy('id', 'desc')->paginate(15)->withQueryString();

        $totalCount = IndustryDomain::count();
        $activeCount = IndustryDomain::where('is_active', true)->count();
        $inactiveCount = $totalCount - $activeCount;
        $categoryGroups = self::getCategoryGroups();

        return view('admin.industries.index', compact(
            'industries',
            'totalCount',
            'activeCount',
            'inactiveCount',
            'categoryGroups',
            'search',
            'status',
            'group'
        ));
    }

    /**
     * Show the form for creating a new industry.
     */
    public function create()
    {
        $categoryGroups = self::getCategoryGroups();
        $nextOrder = (IndustryDomain::max('sort_order') ?? 0) + 1;

        return view('admin.industries.create', compact('categoryGroups', 'nextOrder'));
    }

    /**
     * Store a newly created industry in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:industry_domains,slug',
            'icon' => 'required|string|max:100',
            'category_group' => 'nullable|string|max:100',
            'highlight_stat' => 'nullable|string|max:50',
            'stat_label' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'hero_tagline' => 'nullable|string|max:500',
            'detailed_content' => 'nullable|string',
            'featured_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'tags' => 'nullable|string',
            'technologies' => 'nullable|string',
            'challenge_titles' => 'nullable|array',
            'challenge_titles.*' => 'nullable|string',
            'challenge_descriptions' => 'nullable|array',
            'challenge_descriptions.*' => 'nullable|string',
            'solution_titles' => 'nullable|array',
            'solution_titles.*' => 'nullable|string',
            'solution_descriptions' => 'nullable|array',
            'solution_descriptions.*' => 'nullable|string',
            'faq_questions' => 'nullable|array',
            'faq_questions.*' => 'nullable|string',
            'faq_answers' => 'nullable|array',
            'faq_answers.*' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'focus_keywords' => 'nullable|string|max:255',
            'custom_schema' => 'nullable|string',
        ]);

        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        if (IndustryDomain::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(4);
        }

        // Process Tags & Technologies
        $tagsArray = $this->commaStringToArray($request->input('tags'));
        $techArray = $this->commaStringToArray($request->input('technologies'));

        // Process Challenges
        $challenges = [];
        if (!empty($request->challenge_titles) && is_array($request->challenge_titles)) {
            foreach ($request->challenge_titles as $i => $title) {
                $t = trim($title ?? '');
                $d = trim($request->challenge_descriptions[$i] ?? '');
                if (!empty($t)) {
                    $challenges[] = ['title' => $t, 'description' => $d];
                }
            }
        }

        // Process Solutions
        $solutions = [];
        if (!empty($request->solution_titles) && is_array($request->solution_titles)) {
            foreach ($request->solution_titles as $i => $title) {
                $t = trim($title ?? '');
                $d = trim($request->solution_descriptions[$i] ?? '');
                if (!empty($t)) {
                    $solutions[] = ['title' => $t, 'description' => $d];
                }
            }
        }

        // Process FAQs
        $faqs = [];
        if (!empty($request->faq_questions) && is_array($request->faq_questions)) {
            foreach ($request->faq_questions as $i => $q) {
                $question = trim($q ?? '');
                $answer = trim($request->faq_answers[$i] ?? '');
                if (!empty($question) && !empty($answer)) {
                    $faqs[] = ['question' => $question, 'answer' => $answer];
                }
            }
        }

        // Handle Image Upload
        $featuredImagePath = null;
        if ($request->hasFile('featured_image_file')) {
            $file = $request->file('featured_image_file');
            $filename = 'industry-' . $slug . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('asset'), $filename);
            $featuredImagePath = 'asset/' . $filename;
        }

        IndustryDomain::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'icon' => $validated['icon'],
            'category_group' => $validated['category_group'] ?? 'Enterprise, SaaS & Tech',
            'highlight_stat' => $validated['highlight_stat'] ?? null,
            'stat_label' => $validated['stat_label'] ?? null,
            'description' => $validated['description'] ?? null,
            'hero_tagline' => $validated['hero_tagline'] ?? null,
            'detailed_content' => $validated['detailed_content'] ?? null,
            'featured_image' => $featuredImagePath,
            'tags' => !empty($tagsArray) ? $tagsArray : null,
            'technologies' => !empty($techArray) ? $techArray : null,
            'challenges' => !empty($challenges) ? $challenges : null,
            'solutions' => !empty($solutions) ? $solutions : null,
            'faqs' => !empty($faqs) ? $faqs : null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'focus_keywords' => $validated['focus_keywords'] ?? null,
            'custom_schema' => $validated['custom_schema'] ?? null,
        ]);

        return redirect()->route('admin.industries.index')->with('success', "Industry '{$validated['name']}' created successfully.");
    }

    /**
     * Show the form for editing the specified industry.
     */
    public function edit(IndustryDomain $industry)
    {
        $categoryGroups = self::getCategoryGroups();

        return view('admin.industries.edit', compact('industry', 'categoryGroups'));
    }

    /**
     * Update the specified industry in storage.
     */
    public function update(Request $request, IndustryDomain $industry)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:industry_domains,slug,' . $industry->id,
            'icon' => 'required|string|max:100',
            'category_group' => 'nullable|string|max:100',
            'highlight_stat' => 'nullable|string|max:50',
            'stat_label' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'hero_tagline' => 'nullable|string|max:500',
            'detailed_content' => 'nullable|string',
            'featured_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'tags' => 'nullable|string',
            'technologies' => 'nullable|string',
            'challenge_titles' => 'nullable|array',
            'challenge_titles.*' => 'nullable|string',
            'challenge_descriptions' => 'nullable|array',
            'challenge_descriptions.*' => 'nullable|string',
            'solution_titles' => 'nullable|array',
            'solution_titles.*' => 'nullable|string',
            'solution_descriptions' => 'nullable|array',
            'solution_descriptions.*' => 'nullable|string',
            'faq_questions' => 'nullable|array',
            'faq_questions.*' => 'nullable|string',
            'faq_answers' => 'nullable|array',
            'faq_answers.*' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'focus_keywords' => 'nullable|string|max:255',
            'custom_schema' => 'nullable|string',
        ]);

        $tagsArray = $this->commaStringToArray($request->input('tags'));
        $techArray = $this->commaStringToArray($request->input('technologies'));

        // Process Challenges
        $challenges = [];
        if (!empty($request->challenge_titles) && is_array($request->challenge_titles)) {
            foreach ($request->challenge_titles as $i => $title) {
                $t = trim($title ?? '');
                $d = trim($request->challenge_descriptions[$i] ?? '');
                if (!empty($t)) {
                    $challenges[] = ['title' => $t, 'description' => $d];
                }
            }
        }

        // Process Solutions
        $solutions = [];
        if (!empty($request->solution_titles) && is_array($request->solution_titles)) {
            foreach ($request->solution_titles as $i => $title) {
                $t = trim($title ?? '');
                $d = trim($request->solution_descriptions[$i] ?? '');
                if (!empty($t)) {
                    $solutions[] = ['title' => $t, 'description' => $d];
                }
            }
        }

        // Process FAQs
        $faqs = [];
        if (!empty($request->faq_questions) && is_array($request->faq_questions)) {
            foreach ($request->faq_questions as $i => $q) {
                $question = trim($q ?? '');
                $answer = trim($request->faq_answers[$i] ?? '');
                if (!empty($question) && !empty($answer)) {
                    $faqs[] = ['question' => $question, 'answer' => $answer];
                }
            }
        }

        // Handle Image Upload
        $featuredImagePath = $industry->featured_image;
        if ($request->hasFile('featured_image_file')) {
            $file = $request->file('featured_image_file');
            $filename = 'industry-' . $validated['slug'] . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('asset'), $filename);
            $featuredImagePath = 'asset/' . $filename;
        }

        $industry->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['slug']),
            'icon' => $validated['icon'],
            'category_group' => $validated['category_group'] ?? $industry->category_group,
            'highlight_stat' => $validated['highlight_stat'] ?? null,
            'stat_label' => $validated['stat_label'] ?? null,
            'description' => $validated['description'] ?? null,
            'hero_tagline' => $validated['hero_tagline'] ?? null,
            'detailed_content' => $validated['detailed_content'] ?? null,
            'featured_image' => $featuredImagePath,
            'tags' => !empty($tagsArray) ? $tagsArray : null,
            'technologies' => !empty($techArray) ? $techArray : null,
            'challenges' => !empty($challenges) ? $challenges : null,
            'solutions' => !empty($solutions) ? $solutions : null,
            'faqs' => !empty($faqs) ? $faqs : null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', false),
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'focus_keywords' => $validated['focus_keywords'] ?? null,
            'custom_schema' => $validated['custom_schema'] ?? null,
        ]);

        return redirect()->route('admin.industries.index')->with('success', "Industry '{$industry->name}' updated successfully.");
    }

    /**
     * Remove the specified industry from storage.
     */
    public function destroy(IndustryDomain $industry)
    {
        $name = $industry->name;
        $industry->delete();

        return redirect()->route('admin.industries.index')->with('success', "Industry '{$name}' deleted successfully.");
    }

    /**
     * Toggle the active status of the industry.
     */
    public function toggle(IndustryDomain $industry)
    {
        $industry->is_active = !$industry->is_active;
        $industry->save();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $industry->is_active,
                'message' => "Industry status changed to " . ($industry->is_active ? 'Active' : 'Inactive')
            ]);
        }

        return redirect()->back()->with('success', "Status updated for '{$industry->name}'.");
    }

    /**
     * Helper to parse comma separated string to clean array.
     */
    private function commaStringToArray(?string $str): array
    {
        if (empty($str)) {
            return [];
        }
        return array_values(array_filter(array_map('trim', explode(',', $str))));
    }
}
