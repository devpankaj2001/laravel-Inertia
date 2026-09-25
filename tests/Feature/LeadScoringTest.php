<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use App\Models\User;
use App\Services\LeadScoringService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadScoringTest extends TestCase
{
    use RefreshDatabase;

    public function test_lead_scoring_service_scores_inquiry()
    {
        $inquiry = Inquiry::create([
            'name' => 'Sophia Martinez',
            'email' => 'sophia@enterprisecloud.io',
            'phone' => '+1 415 555 7890',
            'company' => 'Enterprise Cloud IO',
            'service_interest' => 'Next.js & Custom Web Architecture',
            'budget' => '$5,000 - $10,000',
            'message' => 'We require a scalable Next.js and Laravel web app with Stripe billing and high-traffic SEO optimization.',
            'country' => 'United States',
            'status' => 'new',
        ]);

        $scored = LeadScoringService::scoreInquiry($inquiry);

        $this->assertNotNull($scored->lead_score);
        $this->assertGreaterThanOrEqual(50, $scored->lead_score);
        $this->assertNotEmpty($scored->lead_intent);
        $this->assertNotEmpty($scored->ai_suggested_reply);
        $this->assertStringContainsString('Sophia', $scored->ai_suggested_reply);
    }

    public function test_admin_can_retrieve_ai_insight_json()
    {
        $user = User::factory()->create();

        $inquiry = Inquiry::create([
            'name' => 'David Kim',
            'email' => 'david@techstartup.com',
            'phone' => '+1 206 555 1234',
            'company' => 'Tech Startup Inc',
            'service_interest' => 'Technical SEO & Core Web Vitals',
            'budget' => '$3,000 - $5,000',
            'message' => 'Looking to improve Core Web Vitals and get page 1 rankings on Google.',
            'country' => 'United States',
            'status' => 'new',
        ]);

        $response = $this->actingAs($user)->getJson(route('admin.inquiries.insight', $inquiry->id));

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'lead' => [
                         'id',
                         'name',
                         'email',
                         'score',
                         'intent',
                         'intent_label',
                         'summary',
                         'suggested_reply',
                     ],
                 ]);
    }
}
