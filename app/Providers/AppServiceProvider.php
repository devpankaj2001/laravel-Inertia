<?php

namespace App\Providers;

use App\Models\Service;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share active services & dynamic categories with frontend views
        View::composer(['layouts.app', 'home', 'services.*', 'blogs.*'], function ($view) {
            try {
                if (Schema::hasTable('services')) {
                    $services = Service::active()->get();
                    $servicesByCategory = [];
                    foreach ($services as $svc) {
                        $cats = $svc->all_categories;
                        foreach ($cats as $c) {
                            $servicesByCategory[$c][] = $svc;
                        }
                    }

                    // Order columns explicitly: Engineering & Architecture -> Growth & Intelligence -> Design & Reliability
                    $priorityOrder = [
                        'Engineering & Architecture',
                        'Growth & Intelligence',
                        'Design & Reliability',
                    ];

                    $orderedCategories = [];
                    foreach ($priorityOrder as $catName) {
                        if (isset($servicesByCategory[$catName])) {
                            $orderedCategories[$catName] = $servicesByCategory[$catName];
                            unset($servicesByCategory[$catName]);
                        }
                    }
                    foreach ($servicesByCategory as $catName => $items) {
                        $orderedCategories[$catName] = $items;
                    }
                    $servicesByCategory = $orderedCategories;

                    $view->with('services', $services);
                    $view->with('servicesByCategory', $servicesByCategory);
                }
            } catch (\Throwable $e) {
                // Ignore during early migrations / CLI bootstrapping
            }
        });
    }
}
