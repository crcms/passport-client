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
        'login' => 'auth.login',
        'register' => 'auth.register',
        'refresh' => 'auth.refresh',
        'user' => 'auth.user',
        'check' => 'auth.check',
        'logout' => 'auth.logout',
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