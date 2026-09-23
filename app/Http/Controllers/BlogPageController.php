<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogPageController extends Controller
{
    /**
     * Display the dynamic blog articles landing page.
     */
    public function index(Request $request)
    {
        $selectedCategory = $request->query('category', 'all');
        $searchQuery = $request->query('search', '');

        $query = BlogPost::published();

        if (!empty($selectedCategory) && strtolower($selectedCategory) !== 'all') {
            $query->where(function ($q) use ($selectedCategory) {
                $q->where('category', 'like', "%{$selectedCategory}%")
                  ->orWhereJsonContains('tags', $selectedCategory);
            });
        }

        if (!empty($searchQuery)) {
            $query->search($searchQuery);
        }

        $posts = $query->paginate(9)->withQueryString();

        // Featured insights for the carousel
        $featuredPosts = BlogPost::featured()->take(6)->get();
        if ($featuredPosts->isEmpty()) {
            $featuredPosts = BlogPost::published()->take(6)->get();
        }

        // Available categories with post counts (published and not scheduled)
        $categories = BlogPost::where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            })
            ->select('category')
            ->selectRaw('count(*) as count')
            ->groupBy('category')
            ->orderBy('category', 'asc')
            ->get();

        // Meta tags
        $metaTitle = "AI & Technology Blogs | Insights from Engineering Leaders | WebRanker";
        $metaDescription = "AI insights, engineering guides, and trends from the WebRanker team — practical reads for CTOs, product leaders, and ML engineers.";
        $canonicalUrl = route('blogs.index');

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
                        'name' => 'Blogs',
                        'item' => $canonicalUrl,
                    ],
                ],
            ],
        ];

        return view('blogs.index', compact(
            'posts',
            'featuredPosts',
            'categories',
            'selectedCategory',
            'searchQuery',
            'metaTitle',
            'metaDescription',
            'canonicalUrl',
            'schemas'
        ));
    }

    /**
     * Display a single detailed blog post.
     */
    public function show(string $slug)
    {
        $post = BlogPost::published()->where('slug', $slug)->firstOrFail();

        // Increment view count safely
        $post->increment('views');

        // Related articles (excluding current post)
        $relatedPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->where(function ($q) use ($post) {
                $q->where('category', $post->category)
                  ->orWhere('author_name', $post->author_name);
            })
            ->take(3)
            ->get();

        if ($relatedPosts->count() < 3) {
            $additional = BlogPost::published()
                ->where('id', '!=', $post->id)
                ->whereNotIn('id', $relatedPosts->pluck('id'))
                ->take(3 - $relatedPosts->count())
                ->get();
            $relatedPosts = $relatedPosts->merge($additional);
        }

        // SEO meta
        $metaTitle = $post->seo_title;
        $metaDescription = $post->seo_description;
        $canonicalUrl = route('blogs.show', $post->slug);
        $ogImage = $post->featured_image_url;

        // Schemas: BlogPosting + Breadcrumbs + FAQs (if present)
        $schemas = [];

        // 1. BlogPosting Schema
        $schemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post->title,
            'description' => $metaDescription,
            'image' => [$ogImage],
            'datePublished' => $post->published_at ? $post->published_at->toIso8601String() : $post->created_at->toIso8601String(),
            'dateModified' => $post->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $post->author_name ?? 'WebRanker Team',
                'jobTitle' => $post->author_role ?? 'AI Engineer',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'WebRanker Technologies',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('asset/logo.svg'),
                ],
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $canonicalUrl,
            ],
        ];

        // 2. BreadcrumbList Schema
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
                    'name' => 'Blogs',
                    'item' => route('blogs.index'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $post->category,
                    'item' => route('blogs.index', ['category' => $post->category]),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 4,
                    'name' => $post->title,
                    'item' => $canonicalUrl,
                ],
            ],
        ];

        // 3. FAQ Schema (if post has FAQs)
        if (!empty($post->faqs) && is_array($post->faqs)) {
            $faqItems = [];
            foreach ($post->faqs as $f) {
                if (!empty($f['question']) && !empty($f['answer'])) {
                    $faqItems[] = [
                        '@type' => 'Question',
                        'name' => $f['question'],
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => strip_tags($f['answer']),
                        ],
                    ];
                }
            }
            if (!empty($faqItems)) {
                $schemas[] = [
                    '@context' => 'https://schema.org',
                    '@type' => 'FAQPage',
                    'mainEntity' => $faqItems,
                ];
            }
        }

        // 4. Custom Schema (if entered)
        if (!empty($post->custom_schema)) {
            $decoded = json_decode($post->custom_schema, true);
            if (is_array($decoded)) {
                $schemas[] = $decoded;
            }
        }

        // Strategic Interlinking: Related Engineering Services
        $relatedServices = Service::active()
            ->where(function ($q) use ($post) {
                $q->where('category', $post->category)
                  ->orWhereJsonContains('categories', $post->category)
                  ->orWhere('title', 'like', "%{$post->category}%");
            })
            ->take(3)
            ->get();

        if ($relatedServices->isEmpty()) {
            $relatedServices = Service::active()->take(3)->get();
        }

        // Auto-inject semantic IDs into <h2> and <h3> tags for deep-anchor jump links & TOC
        $rawContent = $post->content ?? '';
        $tableOfContents = [];
        $contentWithAnchors = preg_replace_callback('/<(h[23])([^>]*)>(.*?)<\/\1>/i', function ($m) use (&$tableOfContents) {
            $tag = strtolower($m[1]);
            $attrs = $m[2];
            $inner = $m[3];
            $cleanTitle = trim(strip_tags($inner));

            if (preg_match('/id="([^"]*)"/i', $attrs, $idMatch)) {
                $id = $idMatch[1];
            } else {
                $id = Str::slug($cleanTitle);
                $attrs .= ' id="' . $id . '"';
            }

            $tableOfContents[] = [
                'id' => $id,
                'title' => $cleanTitle,
                'level' => $tag,
            ];

            return "<{$tag}{$attrs}>{$inner}</{$tag}>";
        }, $rawContent);

        $post->content = $contentWithAnchors;

        return view('blogs.show', compact(
            'post',
            'relatedPosts',
            'relatedServices',
            'tableOfContents',
            'metaTitle',
            'metaDescription',
            'canonicalUrl',
            'ogImage',
            'schemas'
        ));
    }
}
