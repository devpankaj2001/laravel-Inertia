<?php

namespace App\Http\Middleware;

use App\Models\IndustryDomain;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return null;
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        // Compute services grouped by category for header mega-menu
        $servicesByCategory = [];
        try {
            $services = Service::active()->get();
            $priorityOrder = [
                'Engineering & Architecture',
                'Growth & Intelligence',
                'Design & Reliability',
            ];
            $grouped = $services->groupBy('category');
            foreach ($priorityOrder as $catName) {
                if ($grouped->has($catName)) {
                    $servicesByCategory[$catName] = $grouped->get($catName)->values()->all();
                }
            }
            foreach ($grouped as $catName => $items) {
                if (!isset($servicesByCategory[$catName])) {
                    $servicesByCategory[$catName] = $items->values()->all();
                }
            }
        } catch (\Throwable $e) {
            $servicesByCategory = [];
        }

        $industriesMenu = [];
        try {
            $industriesMenu = IndustryDomain::active()
                ->select('id', 'name', 'slug', 'category_group', 'description', 'hero_tagline', 'icon')
                ->orderBy('name')
                ->get();
        } catch (\Throwable $e) {
            $industriesMenu = [];
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
                'link_success' => fn () => $request->session()->get('link_success'),
            ],
            'navServicesByCategory' => $servicesByCategory,
            'navIndustries' => $industriesMenu,
            'siteConfig' => [
                'name' => config('site.name'),
                'phone' => config('site.phone'),
                'email' => config('site.email'),
                'address' => config('site.address'),
                'timing' => config('site.timing'),
                'support_email' => config('site.support_email'),
                'twitter' => config('site.twitter'),
                'linkedin' => config('site.linkedin'),
                'github' => config('site.github'),
            ],
        ];
    }
}
