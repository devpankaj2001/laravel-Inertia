<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Global Rankexa (Rankexa.in) Site Information & Contact Constants
    |--------------------------------------------------------------------------
    | Managed centrally via .env file so any change automatically updates
    | across all controllers, Blade views, and Inertia React components.
    */

    'name' => env('SITE_NAME', 'Rankexa'),
    'domain' => env('SITE_DOMAIN', 'Rankexa.in'),
    'url' => env('APP_URL', 'https://rankexa.in'),
    'email' => env('SITE_CONTACT_EMAIL', 'info@rankexa.in'),
    'phone' => env('SITE_CONTACT_PHONE', '+91 94147 90938'),
    'address' => env('SITE_CONTACT_ADDRESS', 'Jaipur Tech Campus / Delhi NCR Hub, India'),
    'timing' => env('SITE_CONTACT_TIMING', 'Monday - Friday: 9:00 AM - 7:00 PM IST (24/7 Monitoring for Enterprise)'),
    'support_email' => env('SITE_SUPPORT_EMAIL', 'support@rankexa.in'),
    'twitter' => env('SITE_TWITTER', 'https://twitter.com/rankexa'),
    'linkedin' => env('SITE_LINKEDIN', 'https://linkedin.com/company/rankexa'),
    'github' => env('SITE_GITHUB', 'https://github.com/rankexa'),
];
