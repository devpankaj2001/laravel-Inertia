<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\ServiceAdminController;
use App\Models\BlogPost;
use App\Models\Service;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * Generate dynamic XML Sitemap for search engines.
     * Note: Pure dynamic generation in real-time (no caching).
     */
    public function sitemap(): Response
    {
        $services = Service::active()->get();
        $blogs = BlogPost::published()->get();
        $serviceCategories = ServiceAdminController::getStandardCategories();
        $blogCategories = BlogPost::published()->reorder()->distinct()->pluck('category')->filter()->values();

        $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $content .= '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

        // 1. Home Page (Top Priority)
        $content .= "  <url>\n";
        $content .= "    <loc>" . htmlspecialchars(url('/')) . "</loc>\n";
        $content .= "    <lastmod>" . now()->toAtomString() . "</lastmod>\n";
        $content .= "    <changefreq>daily</changefreq>\n";
        $content .= "    <priority>1.0</priority>\n";
        $content .= "  </url>\n";

        // 2. Services Hub & Directory
        $content .= "  <url>\n";
        $content .= "    <loc>" . htmlspecialchars(url('/services')) . "</loc>\n";
        $content .= "    <lastmod>" . now()->toAtomString() . "</lastmod>\n";
        $content .= "    <changefreq>daily</changefreq>\n";
        $content .= "    <priority>0.9</priority>\n";
        $content .= "  </url>\n";

        // 3. Blog Hub & Insights Directory
        $content .= "  <url>\n";
        $content .= "    <loc>" . htmlspecialchars(url('/blogs')) . "</loc>\n";
        $content .= "    <lastmod>" . now()->toAtomString() . "</lastmod>\n";
        $content .= "    <changefreq>daily</changefreq>\n";
        $content .= "    <priority>0.9</priority>\n";
        $content .= "  </url>\n";

        // 4. Dynamic Dedicated Service Landing Pages
        foreach ($services as $service) {
            $content .= "  <url>\n";
            $content .= "    <loc>" . htmlspecialchars(url('/services/' . $service->slug)) . "</loc>\n";
            $content .= "    <lastmod>" . $service->updated_at->toAtomString() . "</lastmod>\n";
            $content .= "    <changefreq>weekly</changefreq>\n";
            $content .= "    <priority>0.85</priority>\n";
            if ($service->og_image) {
                $content .= "    <image:image>\n";
                $content .= "      <image:loc>" . htmlspecialchars(asset($service->og_image)) . "</image:loc>\n";
                $content .= "      <image:title>" . htmlspecialchars($service->title) . "</image:title>\n";
                $content .= "    </image:image>\n";
            }
            $content .= "  </url>\n";
        }

        // 5. Dynamic Dedicated Blog Articles (Canonical Permalinks)
        foreach ($blogs as $blog) {
            $content .= "  <url>\n";
            $content .= "    <loc>" . htmlspecialchars(url('/blog/' . $blog->slug)) . "</loc>\n";
            $content .= "    <lastmod>" . $blog->updated_at->toAtomString() . "</lastmod>\n";
            $content .= "    <changefreq>weekly</changefreq>\n";
            $content .= "    <priority>0.80</priority>\n";
            if ($blog->featured_image) {
                $content .= "    <image:image>\n";
                $content .= "      <image:loc>" . htmlspecialchars(asset($blog->featured_image)) . "</image:loc>\n";
                $content .= "      <image:title>" . htmlspecialchars($blog->title) . "</image:title>\n";
                $content .= "    </image:image>\n";
            }
            $content .= "  </url>\n";
        }

        // 6. Dynamic Service Category Index URLs
        foreach ($serviceCategories as $scat) {
            $content .= "  <url>\n";
            $content .= "    <loc>" . htmlspecialchars(url('/services?category=' . urlencode($scat))) . "</loc>\n";
            $content .= "    <lastmod>" . now()->toAtomString() . "</lastmod>\n";
            $content .= "    <changefreq>weekly</changefreq>\n";
            $content .= "    <priority>0.70</priority>\n";
            $content .= "  </url>\n";
        }

        // 7. Dynamic Blog Category Index URLs
        foreach ($blogCategories as $bcat) {
            $content .= "  <url>\n";
            $content .= "    <loc>" . htmlspecialchars(url('/blogs?category=' . urlencode($bcat))) . "</loc>\n";
            $content .= "    <lastmod>" . now()->toAtomString() . "</lastmod>\n";
            $content .= "    <changefreq>weekly</changefreq>\n";
            $content .= "    <priority>0.70</priority>\n";
            $content .= "  </url>\n";
        }

        $content .= '</urlset>';

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'X-Robots-Tag' => 'noindex',
        ]);
    }

    /**
     * Generate dynamic robots.txt file for search engine crawlers.
     */
    public function robots(): Response
    {
        $sitemapUrl = url('/sitemap.xml');

        $content = <<<ROBOTS
User-agent: *
Allow: /
Allow: /blogs
Allow: /blog/
Allow: /services
Allow: /services/

# Disallow internal form endpoints and admin areas
Disallow: /inquiry
Disallow: /link-request
Disallow: /admin/
Disallow: /api/

# Crawl-delay for polite crawling
Crawl-delay: 1

# Dynamic XML Sitemap
Sitemap: {$sitemapUrl}
ROBOTS;

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
        ]);
    }
}
