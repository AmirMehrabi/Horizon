<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OpenStack Authentication Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for connecting to your OpenStack
    | cloud infrastructure. The authentication URL should point to your
    | Keystone identity service endpoint.
    |
    */

    'auth_url' => env('OPENSTACK_AUTH_URL', 'http://185.206.95.239:5000/v3'),

    'region' => env('OPENSTACK_REGION', 'RegionOne'),

    /*
    |--------------------------------------------------------------------------
    | Authentication Method
    |--------------------------------------------------------------------------
    |
    | You can authenticate using either username/password or user ID.
    | If using username, set OPENSTACK_USERNAME and OPENSTACK_PASSWORD.
    | If using user ID, set OPENSTACK_USER_ID and OPENSTACK_PASSWORD.
    |
    */

    'user_id' => env('OPENSTACK_USER_ID'),
    'username' => env('OPENSTACK_USERNAME', 'admin'),
    'password' => env('OPENSTACK_PASSWORD', 'supsecret02'),

    /*
    |--------------------------------------------------------------------------
    | Project/Tenant Configuration
    |--------------------------------------------------------------------------
    |
    | Specify the project (tenant) you want to use. You can use either
    | project ID or project name. If using project name, you may also
    | need to specify the domain.
    |
    */

    'project_id' => env('OPENSTACK_PROJECT_ID'),
    'project_name' => env('OPENSTACK_PROJECT_NAME', 'admin'),

    /*
    |--------------------------------------------------------------------------
    | Domain Configuration
    |--------------------------------------------------------------------------
    |
    | OpenStack domains are used for multi-tenancy. The default domain
    | is typically 'default' or 'Default'. You can specify by ID or name.
    |
    */

    'domain_id' => env('OPENSTACK_DOMAIN_ID', 'default'),
    'domain_name' => env('OPENSTACK_DOMAIN_NAME', 'Default'),

    /*
    |--------------------------------------------------------------------------
    | Connection Settings
    |--------------------------------------------------------------------------
    |
    | Timeout settings for API calls and connection retries.
    |
    */

    'timeout' => env('OPENSTACK_TIMEOUT', 30),
    'connect_timeout' => env('OPENSTACK_CONNECT_TIMEOUT', 10),

    /*
    |--------------------------------------------------------------------------
    | Sync Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for syncing resources from OpenStack to local database.
    |
    */

    'sync_interval' => env('OPENSTACK_SYNC_INTERVAL', 300), // 5 minutes in seconds
    'sync_enabled' => env('OPENSTACK_SYNC_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Service Endpoints
    |--------------------------------------------------------------------------
    |
    | These are typically auto-discovered from the service catalog,
    | but you can override them if needed.
    |
    */

    'compute_endpoint' => env('OPENSTACK_COMPUTE_ENDPOINT'),
    'network_endpoint' => env('OPENSTACK_NETWORK_ENDPOINT'),
    'image_endpoint' => env('OPENSTACK_IMAGE_ENDPOINT'),
    'identity_endpoint' => env('OPENSTACK_IDENTITY_ENDPOINT'),

];

