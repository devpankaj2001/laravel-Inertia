<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustryDomain extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'category_group',
        'highlight_stat',
        'stat_label',
        'description',
        'hero_tagline',
        'detailed_content',
        'challenges',
        'solutions',
        'technologies',
        'kpis',
        'faqs',
        'featured_image',
        'tags',
        'sort_order',
        'is_active',
        'meta_title',
        'meta_description',
        'focus_keywords',
        'custom_schema',
    ];

    protected $casts = [
        'tags' => 'array',
        'challenges' => 'array',
        'solutions' => 'array',
        'technologies' => 'array',
        'kpis' => 'array',
        'faqs' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $appends = [
        'icon_class',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category_group', $category);
    }

    /**
     * Helper to return standard icon class (ensures 'fas ' or 'fa-solid ' prefix).
     */
    public function getIconClassAttribute(): string
    {
        $icon = trim($this->icon ?? 'fa-cube');
        if (!str_contains($icon, 'fa-solid') && !str_contains($icon, 'fas') && !str_contains($icon, 'fab') && !str_contains($icon, 'far')) {
            if (!str_starts_with($icon, 'fa-')) {
                return "fa-solid fa-{$icon}";
            }
            return "fa-solid {$icon}";
        }
        return $icon;
    }

    /**
     * Compute fallback or custom featured image.
     */
    public function getFeaturedImageUrlAttribute(): string
    {
        if (!empty($this->featured_image)) {
            $imagePath = public_path($this->featured_image);
            if (file_exists($imagePath) && filesize($imagePath) > 1000) {
                return asset($this->featured_image);
            }
        }
        return asset('asset/webranker-default-blog.jpg');
    }

    /**
     * Dynamic SEO title.
     */
    public function getSeoTitleAttribute(): string
    {
        if (!empty($this->meta_title)) {
            return $this->meta_title;
        }
        return "{$this->name} Digital Engineering & SEO Architecture | WebRanker";
    }

    /**
     * Dynamic SEO description.
     */
    public function getSeoDescriptionAttribute(): string
    {
        if (!empty($this->meta_description)) {
            return $this->meta_description;
        }
        if (!empty($this->description)) {
            return "WebRanker builds mission-critical, high-ranking digital systems for {$this->name}. {$this->description}";
        }
        return "Enterprise engineering, technical SEO, and conversion architectures engineered specifically for {$this->name}.";
    }
}

