<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    | This configuration is for LOCAL DEVELOPMENT (React + Laravel)
    | Before pushing to production, UPDATE allowed_origins
    |--------------------------------------------------------------------------
    */

    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
    ],

    'allowed_methods' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | LOCALHOST ORIGINS (React)
    |--------------------------------------------------------------------------
    | React common ports:
    | - CRA: 3000
    | - Vite: 5173
    |--------------------------------------------------------------------------
    */
    'allowed_origins' => [
        'http://localhost:3000',
        'http://localhost:5173',
        'http://127.0.0.1:3000',
        'http://127.0.0.1:5173',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    /*
    |--------------------------------------------------------------------------
    | Set TRUE if using Sanctum / Cookies / Auth
    |--------------------------------------------------------------------------
    */
    'supports_credentials' => true,

];
