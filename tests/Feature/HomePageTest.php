<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use Database\Seeders\HomeContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(HomeContentSeeder::class);
    }

    /**
     * Test Home Page loads with HTTP 200 and essential SEO elements.
     */
    public function test_home_page_loads_successfully_with_seo_metadata(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        // Verify SEO & Core Meta
        $response->assertSee('<title>WebRanker', false);
        $response->assertSee('<meta name="description"', false);
        $response->assertSee('<link rel="canonical"', false);
        $response->assertSee('application/ld+json', false);
        $response->assertSee('https://schema.org', false);
        $response->assertSee('FAQPage', false);
        $response->assertSee('LocalBusiness', false);
        $response->assertSee('Organization', false);

        // Verify Dynamic Sections & Brand
        $response->assertSee('WebRanker');
        $response->assertSee('FREE AUDIT');
        $response->assertSee('Certification');
        $response->assertSee('Blogs');
        $response->assertSee('Case Studies');
        $response->assertSee('header-chamfer-btn');
        $response->assertSee('header-brand-wrap');
        $response->assertSee('How We Grow You');
        $response->assertSee('GROWTH &amp; ENGINEERING INSIGHTS', false);
    }

    /**
     * Test Lead Capture / Inquiry submission saves to database.
     */
    public function test_inquiry_submission_stores_lead_in_database(): void
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'john@testcompany.com',
            'phone' => '+1 555-123-4567',
            'company' => 'Test Company Inc',
            'service_interest' => 'Complete Growth Audit',
            'budget' => '$10,000 - $25,000',
            'message' => 'Looking to increase organic rankings and fix Core Web Vitals.',
        ];

        $response = $this->postJson('/inquiry', $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('inquiries', [
            'email' => 'john@testcompany.com',
            'name' => 'John Doe',
        ]);
    }

    /**
     * Test XML Sitemap generation.
     */
    public function test_sitemap_xml_returns_valid_xml(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $this->assertStringContainsString('xml', strtolower($response->headers->get('Content-Type') ?? ''));
        $response->assertSee('<?xml version="1.0" encoding="UTF-8"?>', false);
        $response->assertSee('<urlset', false);
    }

    /**
     * Test robots.txt generation.
     */
    public function test_robots_txt_returns_proper_directives(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $response->assertSee('User-agent: *');
        $response->assertSee('Allow: /');
        $response->assertSee('Sitemap:');
    }
}
