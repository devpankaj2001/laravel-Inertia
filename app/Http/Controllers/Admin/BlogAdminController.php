<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogAdminController extends Controller
{
    /**
     * Display a listing of blog articles in the admin console.
     */
    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $categoryFilter = $request->query('category', '');
        $statusFilter = $request->query('status', '');

        $query = BlogPost::query()->orderBy('id', 'desc');

        if (!empty($search)) {
            $query->search($search);
        }

        if (!empty($categoryFilter)) {
            $query->where('category', $categoryFilter);
        }

        if ($statusFilter === 'published') {
            $query->where('is_published', true)->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
        } elseif ($statusFilter === 'scheduled') {
            $query->where('is_published', true)->where('published_at', '>', now());
        } elseif ($statusFilter === 'draft') {
            $query->where('is_published', false);
        }

        $posts = $query->paginate(15)->withQueryString();

        // Stats
        $totalPosts = BlogPost::count();
        $publishedCount = BlogPost::published()->count();
        $scheduledCount = BlogPost::scheduled()->count();
        $draftCount = BlogPost::where('is_published', false)->count();

        // Distinct categories for filter
        $categories = BlogPost::select('category')->distinct()->pluck('category')->filter()->values();

        return view('admin.blogs.index', compact(
            'posts',
            'totalPosts',
            'publishedCount',
            'scheduledCount',
            'draftCount',
            'categories',
            'search',
            'categoryFilter',
            'statusFilter'
        ));
    }

    /**
     * Show the form for creating a new blog article.
     */
    public function create()
    {
        $categories = BlogPost::select('category')->distinct()->pluck('category')->filter()->values();
        return view('admin.blogs.create', compact('categories'));
    }

    /**
     * Store a newly created blog article in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_posts,slug',
            'category' => 'required|string|max:100',
            'category_new' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'excerpt' => 'required|string|max:1000',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|string|max:255',
            'featured_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg,gif|max:5120',
            'author_name' => 'nullable|string|max:100',
            'author_role' => 'nullable|string|max:100',
            'read_time' => 'nullable|string|max:50',
            'is_published' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'focus_keywords' => 'nullable|string|max:255',
            'faq_questions' => 'nullable|array',
            'faq_questions.*' => 'nullable|string',
            'faq_answers' => 'nullable|array',
            'faq_answers.*' => 'nullable|string',
            'custom_schema' => 'nullable|string',
        ]);

        // Category resolution
        $finalCategory = !empty($validated['category_new']) ? trim($validated['category_new']) : $validated['category'];

        // Tags parsing (comma-separated to array)
        $tagsArray = [];
        if (!empty($request->input('tags'))) {
            $tagsArray = array_values(array_filter(array_map('trim', explode(',', $request->input('tags')))));
        }

        // FAQs parsing
        $faqs = [];
        if (!empty($request->faq_questions) && is_array($request->faq_questions)) {
            foreach ($request->faq_questions as $idx => $q) {
                $q = trim($q ?? '');
                $a = trim($request->faq_answers[$idx] ?? '');
                if (!empty($q) && !empty($a)) {
                    $faqs[] = ['question' => $q, 'answer' => $a];
                }
            }
        }

        // Custom JSON-LD validation
        $customSchema = null;
        if (!empty($request->custom_schema)) {
            $trimmed = trim($request->custom_schema);
            json_decode($trimmed);
            if (json_last_error() === JSON_ERROR_NONE) {
                $customSchema = $trimmed;
            }
        }

        // Cover Image Upload or Path
        $featuredImage = 'asset/blog_icon_bg.png';
        if ($request->hasFile('featured_image_file')) {
            $file = $request->file('featured_image_file');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/blogs'), $filename);
            $featuredImage = 'uploads/blogs/' . $filename;
        } elseif (!empty($validated['featured_image'])) {
            $featuredImage = trim($validated['featured_image']);
        }

        // Author Name: always default to logged-in user
        $authorName = auth()->user()->name ?? (!empty($validated['author_name']) ? $validated['author_name'] : 'Admin');

        // Auto-calculate reading time based on content word count
        $readTime = BlogPost::calculateReadTime($request->input('content'));

        // Publish & Scheduled Date/Time handling
        $isPublished = $request->has('is_published');
        $publishedAt = null;
        if ($request->filled('published_at')) {
            $publishedAt = \Carbon\Carbon::parse($request->input('published_at'));
        } elseif ($isPublished) {
            $publishedAt = now();
        }

        $post = BlogPost::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['slug']),
            'category' => $finalCategory,
            'tags' => $tagsArray,
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'] ?? null,
            'featured_image' => $featuredImage,
            'author_name' => $authorName,
            'author_role' => !empty($validated['author_role']) ? $validated['author_role'] : 'Technical Specialist',
            'read_time' => $readTime,
            'is_published' => $isPublished,
            'is_featured' => $request->has('is_featured') ? true : false,
            'published_at' => $publishedAt,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'focus_keywords' => $validated['focus_keywords'] ?? null,
            'faqs' => !empty($faqs) ? $faqs : null,
            'custom_schema' => $customSchema,
        ]);

        $statusMsg = $post->is_scheduled
            ? "Article '{$post->title}' scheduled for publication on " . $post->published_at->format('M d, Y H:i') . "!"
            : "Article '{$post->title}' created successfully!";

        return redirect()->route('admin.blogs.index')->with('success', $statusMsg);
    }

    /**
     * Show the form for editing the specified blog article.
     */
    public function edit(BlogPost $blog)
    {
        $categories = BlogPost::select('category')->distinct()->pluck('category')->filter()->values();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified blog article in storage.
     */
    public function update(Request $request, BlogPost $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_posts,slug,' . $blog->id,
            'category' => 'required|string|max:100',
            'category_new' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'excerpt' => 'required|string|max:1000',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|string|max:255',
            'featured_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg,gif|max:5120',
            'author_name' => 'nullable|string|max:100',
            'author_role' => 'nullable|string|max:100',
            'read_time' => 'nullable|string|max:50',
            'is_published' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'focus_keywords' => 'nullable|string|max:255',
            'faq_questions' => 'nullable|array',
            'faq_questions.*' => 'nullable|string',
            'faq_answers' => 'nullable|array',
            'faq_answers.*' => 'nullable|string',
            'custom_schema' => 'nullable|string',
        ]);

        $finalCategory = !empty($validated['category_new']) ? trim($validated['category_new']) : $validated['category'];

        $tagsArray = [];
        if (!empty($request->input('tags'))) {
            $tagsArray = array_values(array_filter(array_map('trim', explode(',', $request->input('tags')))));
        }

        $faqs = [];
        if (!empty($request->faq_questions) && is_array($request->faq_questions)) {
            foreach ($request->faq_questions as $idx => $q) {
                $q = trim($q ?? '');
                $a = trim($request->faq_answers[$idx] ?? '');
                if (!empty($q) && !empty($a)) {
                    $faqs[] = ['question' => $q, 'answer' => $a];
                }
            }
        }

        $customSchema = null;
        if (!empty($request->custom_schema)) {
            $trimmed = trim($request->custom_schema);
            json_decode($trimmed);
            if (json_last_error() === JSON_ERROR_NONE) {
                $customSchema = $trimmed;
            }
        }

        // Cover Image Upload or Retain
        $featuredImage = $blog->featured_image ?: 'asset/blog_icon_bg.png';
        if ($request->hasFile('featured_image_file')) {
            $file = $request->file('featured_image_file');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/blogs'), $filename);
            $featuredImage = 'uploads/blogs/' . $filename;
        } elseif ($request->filled('featured_image')) {
            $featuredImage = trim($request->input('featured_image'));
        }

        // Author Name
        $authorName = !empty($validated['author_name'])
            ? $validated['author_name']
            : ($blog->author_name ?: (auth()->user()->name ?? 'Admin'));

        // Auto-calculate reading time
        $readTime = BlogPost::calculateReadTime($request->input('content'));

        $isPublished = $request->has('is_published');
        $publishedAt = $blog->published_at;
        if ($request->filled('published_at')) {
            $publishedAt = \Carbon\Carbon::parse($request->input('published_at'));
        } elseif ($isPublished && empty($publishedAt)) {
            $publishedAt = now();
        }

        $blog->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['slug']),
            'category' => $finalCategory,
            'tags' => $tagsArray,
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'] ?? null,
            'featured_image' => $featuredImage,
            'author_name' => $authorName,
            'author_role' => !empty($validated['author_role']) ? $validated['author_role'] : ($blog->author_role ?: 'Technical Specialist'),
            'read_time' => $readTime,
            'is_published' => $isPublished,
            'is_featured' => $request->has('is_featured') ? true : false,
            'published_at' => $publishedAt,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'focus_keywords' => $validated['focus_keywords'] ?? null,
            'faqs' => !empty($faqs) ? $faqs : null,
            'custom_schema' => $customSchema,
        ]);

        $statusMsg = $blog->is_scheduled
            ? "Article '{$blog->title}' updated and scheduled for publication on " . $blog->published_at->format('M d, Y H:i') . "!"
            : "Article '{$blog->title}' updated successfully!";

        return redirect()->route('admin.blogs.index')->with('success', $statusMsg);
    }

    /**
     * Remove the specified blog article from storage.
     */
    public function destroy(BlogPost $blog)
    {
        $title = $blog->title;
        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', "Article '{$title}' permanently deleted.");
    }

    /**
     * Toggle the published status of an article.
     */
    public function toggle(BlogPost $blog)
    {
        $blog->is_published = !$blog->is_published;
        if ($blog->is_published && empty($blog->published_at)) {
            $blog->published_at = now();
        }
        $blog->save();

        $statusText = $blog->is_published ? 'published' : 'moved to drafts';
        return redirect()->back()->with('success', "'{$blog->title}' has been {$statusText}.");
    }

    /**
     * Category and tag management overview.
     */
    public function categories()
    {
        $categories = BlogPost::select('category')
            ->selectRaw('count(*) as count')
            ->groupBy('category')
            ->orderBy('category', 'asc')
            ->get();

        return view('admin.blogs.categories', compact('categories'));
    }
}
