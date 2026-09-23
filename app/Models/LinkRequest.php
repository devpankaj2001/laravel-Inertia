<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LinkRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_name',
        'client_email',
        'client_company',
        'country',
        'client_website',
        'target_page_url',
        'target_page_title',
        'requested_anchor_text',
        'target_link_url',
        'link_type',
        'budget_offer',
        'proposed_context',
        'message',
        'status',
        'admin_notes',
    ];

    /**
     * Scope for pending requests.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for accepted requests.
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Get human-readable status badge classes and label.
     */
    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'accepted' => ['label' => 'Accepted', 'class' => 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30'],
            'published' => ['label' => 'Published', 'class' => 'bg-blue-500/20 text-blue-400 border-blue-500/30'],
            'reviewed' => ['label' => 'Reviewed', 'class' => 'bg-amber-500/20 text-amber-400 border-amber-500/30'],
            'rejected' => ['label' => 'Declined', 'class' => 'bg-red-500/20 text-red-400 border-red-500/30'],
            default => ['label' => 'Pending Review', 'class' => 'bg-purple-500/20 text-purple-300 border-purple-500/30'],
        };
    }

    /**
     * Get human-readable link type label.
     */
    public function getLinkTypeLabelAttribute(): string
    {
        return match ($this->link_type) {
            'guest_post' => 'Guest Post Contribution',
            'sponsored_feature' => 'Sponsored Editorial Feature',
            'service_partnership' => 'Service Partnership Co-Marketing',
            default => 'Contextual Link Insertion',
        };
    }
}
