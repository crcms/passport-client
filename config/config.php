<?php

return [
    /*
    |--------------------------------------------------------------------------
    | The application key
    |--------------------------------------------------------------------------
    |
    | System application key
    |
    */

    'key' => env('PASSPORT_KEY', null),

    /*
    |--------------------------------------------------------------------------
    | The application secret
    |--------------------------------------------------------------------------
    |
    | System application secret
    |
    */

    'secret' => env('PASSPORT_SECRET', null),

    /*
    |--------------------------------------------------------------------------
    | The micro service name
    |--------------------------------------------------------------------------
    |
    | The micro service name that needs to be invoked for communication
    |
    */

    'service' => env('PASSPORT_SERVICE', 'passport'),

    /*
    |--------------------------------------------------------------------------
    | The passport api uris
    |--------------------------------------------------------------------------
    |
    | Passport - related interactive authentication interface
    |
    */

    'routes' => [
        'login' => '/api/v1/login',
        'refresh' => '/api/v1/refresh-token',
        'user' => '/api/v1/user',
        'check' => '/api/v1/check-login',
        'logout' => '/api/v1/logout',
    ],

    /*
    |--------------------------------------------------------------------------
    | Local user model
    |--------------------------------------------------------------------------
    |
    | Data model for local interaction
    |
    */

    'user' => \CrCms\App\User::class,
];