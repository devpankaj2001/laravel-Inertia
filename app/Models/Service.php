<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'categories',
        'icon',
        'tagline',
        'short_description',
        'meta_title',
        'meta_description',
        'focus_keywords',
        'og_image',
        'detailed_content',
        'badge',
        'features',
        'faqs',
        'local_schema',
        'business_schema',
        'custom_schema',
        'process_steps',
        'technologies',
        'kpi_label',
        'kpi_value',
        'sort_order',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'categories' => 'array',
        'features' => 'array',
        'faqs' => 'array',
        'local_schema' => 'array',
        'business_schema' => 'array',
        'process_steps' => 'array',
        'technologies' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order', 'asc');
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where(function ($q) use ($category) {
            $q->where('category', $category)
              ->orWhereJsonContains('categories', $category);
        })->active();
    }

    /**
     * Get list of all assigned categories as clean array.
     */
    public function getAllCategoriesAttribute(): array
    {
        if (!empty($this->categories) && is_array($this->categories) && count($this->categories) > 0) {
            return array_values(array_filter($this->categories));
        }

        if (!empty($this->category)) {
            return [trim($this->category)];
        }

        return ['General'];
    }

    /**
     * Get computed high-ranking SEO meta title.
     */
    public function getSeoTitleAttribute(): string
    {
        if (!empty($this->meta_title)) {
            return $this->meta_title;
        }

        return "{$this->title} | WebRanker - Web & App Development, SEO & Performance";
    }

    /**
     * Get computed SEO meta description.
     */
    public function getSeoDescriptionAttribute(): string
    {
        if (!empty($this->meta_description)) {
            return $this->meta_description;
        }

        if (!empty($this->short_description)) {
            return rtrim($this->short_description, '.') . ". High-velocity engineering, technical SEO dominance, and sub-second performance by WebRanker.";
        }

        return "Elite {$this->title} by WebRanker. We engineer scalable architectures, organic search dominance, and conversion-optimized experiences.";
    }

    /**
     * Get computed focus keywords.
     */
    public function getSeoKeywordsAttribute(): string
    {
        if (!empty($this->focus_keywords)) {
            return $this->focus_keywords;
        }

        $base = strtolower($this->title);
        $cat = strtolower($this->category);

        return "{$base}, {$base} agency, {$cat}, technical SEO, high performance development, core web vitals, WebRanker";
    }

    /**
     * Get resolved FAQs list (custom or synthesized defaults).
     */
    public function getResolvedFaqsAttribute(): array
    {
        if (!empty($this->faqs) && is_array($this->faqs) && count($this->faqs) > 0) {
            return $this->faqs;
        }

        // High-intent SEO default FAQs tailored to this service
        return [
            [
                'question' => "What is included in WebRanker's {$this->title}?",
                'answer' => "Our {$this->title} includes comprehensive discovery, bespoke architecture engineering, performance tuning (aiming for sub-second Core Web Vitals), responsive cross-platform compatibility, and technical SEO schema injection."
            ],
            [
                'question' => "How long does a typical {$this->title} project take?",
                'answer' => "Standard implementations typically span between 2 to 6 weeks depending on enterprise scope, third-party API integrations, and testing cycles. We deliver in agile 2-week sprints with full client visibility."
            ],
            [
                'question' => "How does WebRanker ensure high organic search rankings for this service?",
                'answer' => "Every deliverable adheres to our strict SEO-first architecture: semantic HTML5 markup, zero-CLS layout engineering, server-side rendering, and automated Schema.org structured data injection so search engines understand your entity graph immediately."
            ],
            [
                'question' => "Do you provide post-launch maintenance, SLAs, and technical support?",
                'answer' => "Yes. We offer 24/7 technical monitoring, uptime SLAs (up to 99.99%), security patching, and ongoing Core Web Vitals optimization retainers to ensure continuous growth."
            ],
        ];
    }
}
