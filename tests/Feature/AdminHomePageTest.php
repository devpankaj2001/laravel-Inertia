<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\HomeContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminHomePageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(HomeContentSeeder::class);
    }

    /**
     * Test unauthenticated access to /admin/home-page redirects to login.
     */
    public function test_guest_cannot_access_home_page_manager(): void
    {
        $response = $this->get('/admin/home-page');
        $response->assertRedirect('/admin/login');
    }

    /**
     * Test admin can view Home Page management console and tabs.
     */
    public function test_admin_can_view_home_page_manager(): void
    {
        $admin = User::where('email', 'admin@webranker.com')->first();

        $response = $this->actingAs($admin)->get('/admin/home-page');
        $response->assertStatus(200);
        $response->assertSee('Home Page &amp; Schema JSON-LD Center', false);
        $response->assertSee('Dynamic Content &amp; Hero', false);
        $response->assertSee('Local Schema (JSON-LD)', false);
        $response->assertSee('Business Schema (JSON-LD)', false);
        $response->assertSee('Custom Schema (JSON-LD)', false);
    }

    /**
     * Test admin can update dynamic home content and see it live on home page.
     */
    public function test_admin_can_update_dynamic_home_content(): void
    {
        $admin = User::where('email', 'admin@webranker.com')->first();

        $payload = [
            'section' => 'content',
            'kicker' => 'ELITE GLOBAL SEARCH DOMINANCE',
            'title' => 'Scaling WebRanker Revenue Overnight',
            'title_accent' => 'With 99+ Core Web Vitals',
            'lead' => 'Custom engineered high-reach SEO architecture for high-growth tech brands.',
            'cta_text' => 'Get My Immediate Growth Audit',
            'cta_link' => '#consultation',
            'secondary_text' => 'Inspect Live Client Results',
            'secondary_link' => '#testimonials',
            'serp_badge' => 'CERTIFIED #1 POSITION',
            'serp_sub' => '+450% traffic surge',
            'proof_labels' => ['SEO Max', 'Fast Web'],
            'proof_descs' => ['High-reach #1', 'Sub-second LCP'],
        ];

        $response = $this->actingAs($admin)->post('/admin/home-page', $payload);
        $response->assertRedirect(route('admin.homepage.index', ['tab' => 'content']));
        $response->assertSessionHas('success');

        // Check that live home page renders the updated content
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('ELITE GLOBAL SEARCH DOMINANCE');
        $homeResponse->assertSee('Scaling WebRanker Revenue Overnight');
        $homeResponse->assertSee('With 99+ Core Web Vitals');
        $homeResponse->assertSee('Get My Immediate Growth Audit');
        $homeResponse->assertSee('CERTIFIED #1 POSITION');
    }

    /**
     * Test admin can update LocalBusiness schema and see it in JSON-LD output.
     */
    public function test_admin_can_update_local_schema_via_home_manager(): void
    {
        $admin = User::where('email', 'admin@webranker.com')->first();

        $payload = [
            'section' => 'local',
            'local_name' => 'WebRanker Jaipur Premier Campus',
            'local_legal_name' => 'WebRanker India Solutions Private Limited',
            'local_street_address' => 'Plot no. 51, Shaheed Amit Bhardwaj Marg, opp. 8/1, Sector 8, Malviya Nagar, Jaipur, Rajasthan 302017',
            'local_address_locality' => 'Jaipur',
            'local_address_region' => 'Rajasthan',
            'local_postal_code' => '302017',
            'local_address_country' => 'IN',
            'local_telephone' => '+91 97185 70218',
            'local_email' => 'contact@webranker.com',
            'local_latitude' => '26.844394',
            'local_longitude' => '75.805302',
            'local_opening_hours' => 'Mo-Sa 09:00-20:00',
            'local_price_range' => '$$$',
            'local_currencies_accepted' => 'INR, USD',
            'local_area_served' => 'Rajasthan, India, Global',
        ];

        $response = $this->actingAs($admin)->post('/admin/home-page', $payload);
        $response->assertRedirect(route('admin.homepage.index', ['tab' => 'local']));
        $response->assertSessionHas('success');

        // Verify on home page JSON-LD
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('WebRanker Jaipur Premier Campus');
        $homeResponse->assertSee('Plot no. 51, Shaheed Amit Bhardwaj Marg, opp. 8/1, Sector 8, Malviya Nagar');
    }

    /**
     * Test admin can update custom JSON-LD schema with validation.
     */
    public function test_admin_can_inject_custom_schema_and_validate_syntax(): void
    {
        $admin = User::where('email', 'admin@webranker.com')->first();

        // 1. Invalid JSON should fail with error
        $invalidPayload = [
            'section' => 'custom',
            'custom_jsonld' => '{ invalid_json_here: true, }',
        ];

        $responseInvalid = $this->actingAs($admin)->post('/admin/home-page', $invalidPayload);
        $responseInvalid->assertSessionHasErrors(['custom_jsonld']);

        // 2. Valid JSON should succeed and render in <head>
        $validJson = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'AggregateRating',
            'ratingValue' => '4.95',
            'reviewCount' => '320',
        ]);

        $validPayload = [
            'section' => 'custom',
            'custom_jsonld' => $validJson,
        ];

        $responseValid = $this->actingAs($admin)->post('/admin/home-page', $validPayload);
        $responseValid->assertRedirect(route('admin.homepage.index', ['tab' => 'custom']));
        $responseValid->assertSessionHas('success');

        // Verify on frontend
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('"ratingValue": "4.95"', false);
    }
}
