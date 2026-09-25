<?php

use App\Http\Controllers\AIChatController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomePageController;
use App\Http\Controllers\Admin\InquiryAdminController;
use App\Http\Controllers\Admin\IndustryAdminController;
use App\Http\Controllers\Admin\LinkRequestAdminController;
use App\Http\Controllers\Admin\SchemaController;
use App\Http\Controllers\Admin\ServiceAdminController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\BlogPageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndustryPageController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\LinkRequestController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\ServicePageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - WebRanker SEO & Ranking Application
|--------------------------------------------------------------------------
*/

// Frontend Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Frontend Contact Page & Growth Inquiries
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/contact-us', function () {
    return redirect()->route('contact', [], 301);
});
Route::get('/contact.html', function () {
    return redirect()->route('contact', [], 301);
});

// Dedicated Frontend Service Pages & Directory
Route::get('/services', [ServicePageController::class, 'index'])->name('services.index');
Route::get('/services/content-writing', function () {
    return redirect()->route('services.show', 'seo-services', 301);
});
Route::get('/services/{slug}.html', function ($slug) {
    if ($slug === 'content-writing') {
        return redirect()->route('services.show', 'seo-services', 301);
    }
    return redirect()->route('services.show', $slug, 301);
});
Route::get('/services/{slug}', [ServicePageController::class, 'show'])->name('services.show');

// Dedicated Frontend Industry Vertical Pages & Directory
Route::get('/industries', [IndustryPageController::class, 'index'])->name('industries.index');
Route::get('/industries/{slug}.html', function ($slug) {
    return redirect()->route('industries.show', $slug, 301);
});
Route::get('/industries/{slug}', [IndustryPageController::class, 'show'])->name('industries.show');

// Dedicated Frontend Blog Pages & Directory
Route::get('/blogs.html', function () {
    $category = request()->query('filter') ?? request()->query('category');
    return $category ? redirect()->route('blogs.index', ['category' => $category], 301) : redirect()->route('blogs.index', [], 301);
});
Route::get('/blogs', [BlogPageController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}.html', function ($slug) {
    return redirect()->route('blogs.show', $slug, 301);
});
Route::get('/blogs/{slug}', function ($slug) {
    return redirect()->route('blogs.show', $slug, 301);
});
Route::get('/blog/{slug}.html', function ($slug) {
    return redirect()->route('blogs.show', $slug, 301);
});
Route::get('/blog/{slug}', [BlogPageController::class, 'show'])->name('blogs.show');

// Frontend Lead Generation / Inquiries & Client Link Insertions
Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiry.store');
Route::post('/link-request', [LinkRequestController::class, 'store'])->name('link_request.store');

// Free AI Assistant Routes (Phase 1)
Route::post('/api/ai-chat', [AIChatController::class, 'chat'])->name('ai.chat.legacy');
Route::post('/api/ai/chat', [AIChatController::class, 'chat'])->name('ai.chat');
Route::get('/api/ai/chat/stream', [AIChatController::class, 'stream'])->name('ai.chat.stream');
Route::post('/api/ai/lead', [AIChatController::class, 'captureLead'])->name('ai.lead');
Route::get('/api/ai/history/{sessionId}', [AIChatController::class, 'history'])->name('ai.history');

// Free Instant SEO & Website Performance Auditor (Feature 2)
Route::post('/api/audit/run', [AuditController::class, 'runAudit'])->name('api.audit.run');
Route::get('/api/audit/{id}', [AuditController::class, 'show'])->name('api.audit.show');

// SEO Sitemaps & Search Engine Directives
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('seo.sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('seo.robots');

/*
|--------------------------------------------------------------------------
| Admin Portal & Schema Management Routes
|--------------------------------------------------------------------------
*/

// Authentication
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthController::class, 'showLoginForm']); // Fallback
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Protected Admin Console
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Overview Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Home Page Management (Dynamic Content, Local, Business & Custom Schema JSON-LD)
    Route::get('/home-page', [HomePageController::class, 'index'])->name('homepage.index');
    Route::post('/home-page', [HomePageController::class, 'update'])->name('homepage.update');

    // Schema & SEO Ranking Center
    Route::get('/schema', [SchemaController::class, 'index'])->name('schema.index');
    Route::post('/schema', [SchemaController::class, 'update'])->name('schema.update');

    // Leads & Inquiries Management
    Route::get('/inquiries', [InquiryAdminController::class, 'index'])->name('inquiries.index');
    Route::post('/inquiries/{inquiry}/status', [InquiryAdminController::class, 'updateStatus'])->name('inquiries.status');
    Route::get('/inquiries/{inquiry}/chat', [InquiryAdminController::class, 'chatHistory'])->name('inquiries.chat');
    Route::post('/inquiries/{inquiry}/reanalyze', [InquiryAdminController::class, 'reanalyze'])->name('inquiries.reanalyze');
    Route::get('/inquiries/{inquiry}/ai-insight', [InquiryAdminController::class, 'aiInsight'])->name('inquiries.insight');

    // Client Link Insertion & Sponsored Requests Management
    Route::get('/link-requests', [LinkRequestAdminController::class, 'index'])->name('link_requests.index');
    Route::post('/link-requests', [LinkRequestAdminController::class, 'store'])->name('link_requests.store');
    Route::put('/link-requests/{linkRequest}', [LinkRequestAdminController::class, 'update'])->name('link_requests.update');
    Route::post('/link-requests/{linkRequest}/status', [LinkRequestAdminController::class, 'updateStatus'])->name('link_requests.status');
    Route::delete('/link-requests/{linkRequest}', [LinkRequestAdminController::class, 'destroy'])->name('link_requests.destroy');
    Route::post('/link-requests/{id}/restore', [LinkRequestAdminController::class, 'restore'])->name('link_requests.restore');

    // Free AI SEO & Performance Audits Management
    Route::get('/audits', [AuditController::class, 'adminIndex'])->name('audits.index');
    Route::delete('/audits/{audit}', [AuditController::class, 'adminDestroy'])->name('audits.destroy');

    // Services & Dynamic Categories Management
    Route::get('/services', [ServiceAdminController::class, 'index'])->name('services.index');
    Route::get('/services/create', [ServiceAdminController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceAdminController::class, 'store'])->name('services.store');
    Route::get('/services/categories', [ServiceAdminController::class, 'categories'])->name('services.categories');
    Route::post('/services/categories/update', [ServiceAdminController::class, 'updateCategory'])->name('services.categories.update');
    Route::get('/services/{service}/edit', [ServiceAdminController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceAdminController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceAdminController::class, 'destroy'])->name('services.destroy');
    Route::post('/services/{service}/toggle', [ServiceAdminController::class, 'toggle'])->name('services.toggle');

    // Blog Articles Management
    Route::get('/blogs', [BlogAdminController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/create', [BlogAdminController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [BlogAdminController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/categories', [BlogAdminController::class, 'categories'])->name('blogs.categories');
    Route::get('/blogs/{blog}/edit', [BlogAdminController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{blog}', [BlogAdminController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{blog}', [BlogAdminController::class, 'destroy'])->name('blogs.destroy');
    Route::post('/blogs/{blog}/toggle', [BlogAdminController::class, 'toggle'])->name('blogs.toggle');

    // Industries & Verticals Management
    Route::get('/industries', [IndustryAdminController::class, 'index'])->name('industries.index');
    Route::get('/industries/create', [IndustryAdminController::class, 'create'])->name('industries.create');
    Route::post('/industries', [IndustryAdminController::class, 'store'])->name('industries.store');
    Route::get('/industries/{industry}/edit', [IndustryAdminController::class, 'edit'])->name('industries.edit');
    Route::put('/industries/{industry}', [IndustryAdminController::class, 'update'])->name('industries.update');
    Route::delete('/industries/{industry}', [IndustryAdminController::class, 'destroy'])->name('industries.destroy');
    Route::post('/industries/{industry}/toggle', [IndustryAdminController::class, 'toggle'])->name('industries.toggle');
});
