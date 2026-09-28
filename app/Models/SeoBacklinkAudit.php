<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoBacklinkAudit extends Model
{
    use HasFactory;

    protected $table = 'seo_backlink_audits';

    protected $fillable = [
        'domain',
        'domain_authority',
        'page_rank',
        'dofollow_ratio',
        'toxic_risk',
        'sample_links',
        'ai_link_opportunities',
        'user_email',
        'user_ip',
    ];

    protected $casts = [
        'sample_links' => 'array',
        'domain_authority' => 'integer',
        'page_rank' => 'float',
        'dofollow_ratio' => 'integer',
    ];
}
