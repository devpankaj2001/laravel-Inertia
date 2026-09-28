<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoKeywordRanking extends Model
{
    use HasFactory;

    protected $table = 'seo_keyword_rankings';

    protected $fillable = [
        'domain',
        'keyword',
        'country',
        'state',
        'district',
        'position',
        'page',
        'ranking_url',
        'competitors',
        'ai_difficulty',
        'ai_intent',
        'search_volume',
        'ai_recommendations',
        'user_email',
        'user_ip',
    ];

    protected $casts = [
        'competitors' => 'array',
        'position' => 'integer',
        'page' => 'integer',
    ];
}
