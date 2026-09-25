<?php

namespace Tests\Feature;

use App\Models\AiAudit;
use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SEOAuditorTest extends TestCase
{
    use RefreshDatabase;

    public function test_audit_endpoint_validates_required_fields()
    {
        $response = $this->postJson('/api/audit/run', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['domain', 'email']);
    }

    public function test_audit_endpoint_successfully_runs_and_creates_records()
    {
        $response = $this->postJson('/api/audit/run', [
            'domain' => 'laravel.com',
            'email' => 'developer@laravel.com',
            'phone' => '+1 555 123 4567',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'audit_id',
                     'domain',
                     'url',
                     'speed_score',
                     'seo_score',
                     'metrics' => [
                         'performance_score',
                         'seo_score',
                         'fcp',
                         'lcp',
                         'cls',
                         'cwv_status',
                     ],
                     'roadmap' => [
                         'executive_summary',
                         'speed_fixes',
                         'keyword_opportunities',
                         'schema_fixes',
                     ],
                 ]);

        $this->assertDatabaseHas('ai_audits', [
            'email' => 'developer@laravel.com',
            'domain_url' => 'https://laravel.com',
        ]);

        // Ensure audit is ONLY saved in ai_audits, not in inquiries table
        $this->assertDatabaseMissing('inquiries', [
            'email' => 'developer@laravel.com',
        ]);
    }
}
