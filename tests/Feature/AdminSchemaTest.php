<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\HomeContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSchemaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(HomeContentSeeder::class);
    }

    /**
     * Test unauthenticated access to admin routes redirects to login.
     */
    public function test_admin_requires_authentication(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');

        $responseSchema = $this->get('/admin/schema');
        $responseSchema->assertRedirect('/admin/login');
    }

    /**
     * Test admin can sign in with valid credentials.
     */
    public function test_admin_can_login_and_access_dashboard(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@webranker.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticated();

        $dashboardResponse = $this->get('/admin');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('System Dashboard');
        $dashboardResponse->assertSee('ADVANCED SEARCH RANKING CENTER');
    }

    /**
     * Test admin can view Schema Management Center.
     */
    public function test_admin_can_view_schema_management_center(): void
    {
        $admin = User::where('email', 'admin@webranker.com')->first();

        $response = $this->actingAs($admin)->get('/admin/schema');

        $response->assertStatus(200);
        $response->assertSee('LocalBusiness Schema');
        $response->assertSee('Organization Schema');
        $response->assertSee('Global SEO &amp; Meta', false);
        $response->assertSee('Custom JSON-LD Schema');
    }

    /**
     * Test updating LocalBusiness schema updates live frontend output.
     */
    public function test_admin_can_update_local_business_schema(): void
    {
        $admin = User::where('email', 'admin@webranker.com')->first();

        $payload = [
            'section' => 'local',
            'local_name' => 'WebRanker Jaipur Enterprise Lab',
            'local_legal_name' => 'WebRanker Technologies Inc.',
            'local_street_address' => 'Tech Tower 9, Malviya Nagar IT Hub',
            'local_address_locality' => 'Jaipur',
            'local_address_region' => 'Rajasthan',
            'local_postal_code' => '302017',
            'local_address_country' => 'IN',
            'local_telephone' => '+91 99999 88888',
            'local_email' => 'contact@webranker.com',
            'local_latitude' => '26.8530',
            'local_longitude' => '75.8050',
            'local_opening_hours' => 'Mo-Sa 08:00-20:00',
            'local_price_range' => '$$$$',
            'local_currencies_accepted' => 'USD, INR, EUR',
            'local_area_served' => 'Global',
        ];

        $response = $this->actingAs($admin)->post('/admin/schema', $payload);
        $response->assertRedirect(route('admin.schema.index'));
        $response->assertSessionHas('success');

        // Verify live home page renders updated LocalBusiness schema
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('WebRanker Jaipur Enterprise Lab');
        $homeResponse->assertSee('+91 99999 88888');
        $homeResponse->assertSee('Tech Tower 9, Malviya Nagar IT Hub');
    }

    /**
     * Test updating Custom JSON-LD schema injects it into live website.
     */
    public function test_admin_can_inject_custom_jsonld_schema(): void
    {
        $admin = User::where('email', 'admin@webranker.com')->first();

        $customSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'SoftwareApplication',
            'name' => 'SuperRank Realtime SEO Validator',
            'applicationCategory' => 'SEOApplication',
            'operatingSystem' => 'Cloud',
        ];

        $payload = [
            'section' => 'custom',
            'custom_jsonld' => json_encode($customSchema, JSON_PRETTY_PRINT),
        ];

        $response = $this->actingAs($admin)->post('/admin/schema', $payload);
        $response->assertRedirect(route('admin.schema.index'));

        // Verify live home page renders the injected custom JSON-LD
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('SuperRank Realtime SEO Validator');
        $homeResponse->assertSee('SEOApplication');
    }

    /**
     * Test invalid JSON in Custom Schema returns error.
     */
    public function test_invalid_custom_jsonld_returns_validation_error(): void
    {
        $admin = User::where('email', 'admin@webranker.com')->first();

        $payload = [
            'section' => 'custom',
            'custom_jsonld' => '{ "invalid_json": true, missing_closing_bracket',
        ];

        $response = $this->actingAs($admin)->post('/admin/schema', $payload);
        $response->assertSessionHasErrors('custom_jsonld');
    }
}
