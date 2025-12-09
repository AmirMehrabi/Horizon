<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Subdomain Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration defines the subdomains for different portals
    | in the application. Each portal has its own subdomain and
    | corresponding authentication guard.
    |
    */

    'admin' => [
        'subdomain' => env('ADMIN_SUBDOMAIN', 'admin'),
        'guard' => 'web',
        'redirect_after_login' => '/dashboard',
        'redirect_after_logout' => '/login',
    ],

    'customer' => [
        'subdomain' => env('CUSTOMER_SUBDOMAIN', 'customer'),
        'guard' => 'customer',
        'redirect_after_login' => '/dashboard',
        'redirect_after_logout' => '/',
    ],

    /*
    |--------------------------------------------------------------------------
    | Main Domain Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the main domain (without subdomain)
    | This will show the landing page with portal selection.
    |
    */
    'main' => [
        'show_landing_page' => true,
        'default_redirect' => '/choose-portal',
    ],

    /*
    |--------------------------------------------------------------------------
    | Domain Settings
    |--------------------------------------------------------------------------
    |
    | Base domain configuration for subdomain routing.
    |
    */
    'base_domain' => env('APP_DOMAIN', 'localhost'),
    'force_https' => env('FORCE_HTTPS', false),
];
