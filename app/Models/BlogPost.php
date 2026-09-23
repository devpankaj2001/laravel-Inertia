<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category',
        'tags',
        'author_name',
        'author_role',
        'author_avatar',
        'read_time',
        'views',
        'is_published',
        'is_featured',
        'published_at',
        'meta_title',
        'meta_description',
        'focus_keywords',
        'faqs',
        'custom_schema',
    ];

    protected $casts = [
        'tags' => 'array',
        'faqs' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->where(function ($q) {
                         $q->whereNull('published_at')
                           ->orWhere('published_at', '<=', now());
                     })
                     ->orderBy('published_at', 'desc');
    }

    public function scopeScheduled($query)
    {
        return $query->where('is_published', true)
                     ->where('published_at', '>', now())
                     ->orderBy('published_at', 'asc');
    }

    public function getIsScheduledAttribute(): bool
    {
        return $this->is_published && $this->published_at && $this->published_at->isFuture();
    }

    public function getStatusLabelAttribute(): string
    {
        if (!$this->is_published) {
            return 'Draft';
        }
        if ($this->is_scheduled) {
            return 'Scheduled';
        }
        return 'Published';
    }

    public static function calculateReadTime(?string $content): string
    {
        if (empty($content)) {
            return '1 min read';
        }
        $words = str_word_count(strip_tags($content));
        $minutes = max(1, (int) ceil($words / 200));
        return "{$minutes} min read";
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->published();
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeSearch($query, ?string $term)
    {
        if (empty($term)) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('excerpt', 'like', "%{$term}%")
              ->orWhere('category', 'like', "%{$term}%")
              ->orWhere('author_name', 'like', "%{$term}%");
        });
    }

    public function getSeoTitleAttribute(): string
    {
        if (!empty($this->meta_title)) {
            return $this->meta_title;
        }

        return "{$this->title} | WebRanker AI Insights & Engineering";
    }

    public function getSeoDescriptionAttribute(): string
    {
        if (!empty($this->meta_description)) {
            return $this->meta_description;
        }

        if (!empty($this->excerpt)) {
            return substr(strip_tags($this->excerpt), 0, 160);
        }

        return "Explore {$this->title} - Practical insights, engineering guides, and AI architectures from WebRanker.";
    }

    /**
     * Get computed author initials for fallback avatar (e.g. 'Rahul Sharma' => 'RS')
     */
    public function getAuthorInitialsAttribute(): string
    {
        $name = trim($this->author_name ?? 'WebRanker Team');
        $parts = explode(' ', $name);
        if (count($parts) >= 2) {
            return strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
        }
        return strtoupper(substr($name, 0, 2));
    }

    /**
     * Get the featured image URL or default branded WebRanker placeholder.
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
}
