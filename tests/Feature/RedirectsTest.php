<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RedirectsTest extends TestCase
{
    use RefreshDatabase;

    public function test_legacy_html_service_routes_redirect_properly()
    {
        $response = $this->get('/services/seo-services.html');
        $response->assertRedirect(route('services.show', 'seo-services'));
        $response->assertStatus(301);

        $response = $this->get('/services/web-development.html');
        $response->assertRedirect(route('services.show', 'web-development'));
        $response->assertStatus(301);

        $response = $this->get('/services/content-writing.html');
        $response->assertRedirect(route('services.show', 'seo-services'));
        $response->assertStatus(301);

        $response = $this->get('/services/content-writing');
        $response->assertRedirect(route('services.show', 'seo-services'));
        $response->assertStatus(301);
    }

    public function test_legacy_blog_routes_redirect_properly()
    {
        $response = $this->get('/blog/ecommerce-seo-conversion-optimization-guide.html');
        $response->assertRedirect(route('blogs.show', 'ecommerce-seo-conversion-optimization-guide'));
        $response->assertStatus(301);

        $response = $this->get('/blogs.html?filter=ecommerce');
        $response->assertRedirect(route('blogs.index', ['category' => 'ecommerce']));
        $response->assertStatus(301);
    }

    public function test_homepage_contains_live_service_links()
    {
        $this->seed();
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee(route('services.show', 'seo-services'));
        $response->assertSee(route('services.show', 'web-development'));
    }
}
