<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiAudit extends Model
{
    use HasFactory;

    protected $table = 'ai_audits';

    protected $fillable = [
        'domain_url',
        'email',
        'phone',
        'speed_score',
        'seo_score',
        'performance_metrics',
        'ai_roadmap',
        'ip_address',
        'country',
        'status',
        'inquiry_id',
    ];

    protected $casts = [
        'speed_score' => 'integer',
        'seo_score' => 'integer',
        'performance_metrics' => 'array',
        'ai_roadmap' => 'array',
    ];

    /**
     * Associated Inquiry Lead
     */
    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }
}
