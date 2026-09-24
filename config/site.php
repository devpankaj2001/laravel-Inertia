<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Global WebRanker Site Information & Contact Constants
    |--------------------------------------------------------------------------
    | Managed centrally via .env file so any change automatically updates
    | across all controllers, Blade views, and Inertia React components.
    */

    'name' => env('SITE_NAME', 'WebRanker'),
    'email' => env('SITE_CONTACT_EMAIL', 'info@webranker.in'),
    'phone' => env('SITE_CONTACT_PHONE', '+91 97185 70218'),
    'address' => env('SITE_CONTACT_ADDRESS', 'Jaipur Tech Campus / Delhi NCR Hub, India'),
    'timing' => env('SITE_CONTACT_TIMING', 'Monday - Friday: 9:00 AM - 7:00 PM IST (24/7 Monitoring for Enterprise)'),
    'support_email' => env('SITE_SUPPORT_EMAIL', 'support@webranker.in'),
    'twitter' => env('SITE_TWITTER', 'https://twitter.com/webranker'),
    'linkedin' => env('SITE_LINKEDIN', 'https://linkedin.com/company/webranker'),
    'github' => env('SITE_GITHUB', 'https://github.com/webranker'),
];
