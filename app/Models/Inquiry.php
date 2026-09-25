<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'service_interest',
        'budget',
        'message',
        'source_url',
        'ip_address',
        'country',
        'user_agent',
        'status',
        'lead_score',
        'lead_intent',
        'ai_summary',
        'ai_suggested_reply',
        'ai_analyzed_at',
        'conversation_id',
        'session_id',
    ];

    protected $casts = [
        'lead_score' => 'integer',
        'ai_analyzed_at' => 'datetime',
    ];

    /**
     * Associated AI Chat Conversation (if captured via AI bot)
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(AIConversation::class, 'conversation_id');
    }

    /**
     * Get CSS badge styling for the lead score / intent
     */
    public function getIntentBadgeClassAttribute(): string
    {
        $score = $this->lead_score ?? 0;
        $intent = strtolower($this->lead_intent ?? '');

        if ($intent === 'enterprise' || $score >= 80) {
            return 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30';
        }
        if ($intent === 'hot' || $score >= 65) {
            return 'bg-amber-500/20 text-amber-400 border-amber-500/30';
        }
        if ($intent === 'warm' || $score >= 40) {
            return 'bg-sky-500/20 text-sky-400 border-sky-500/30';
        }
        if ($intent === 'spam' || $score < 25) {
            return 'bg-red-500/20 text-red-400 border-red-500/30';
        }

        return 'bg-slate-700/50 text-slate-300 border-slate-600';
    }

    /**
     * Get human-readable intent label with icon
     */
    public function getIntentLabelAttribute(): string
    {
        $intent = strtolower($this->lead_intent ?? 'unscored');

        return match ($intent) {
            'enterprise' => '🚀 Enterprise Buyer',
            'hot' => '🔥 High-Intent Lead',
            'warm' => '⚡ Qualified Lead',
            'cold' => '❄️ General Inquiry',
            'spam' => '🛑 Low Quality / Spam',
            default => '⏳ Unanalyzed',
        };
    }
}
