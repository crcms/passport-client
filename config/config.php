<?php

return [
    'key' => env('PASSPORT_KEY', null),
    'secret' => env('PASSPORT_SECRET', null),
    'host' => env('PASSPORT_HOST', null),
    'ssl' => env('PASSPORT_SSL', null),
    'routes' => [
        'login' => env('PASSPORT_HOST', null) . '/login',
        'refresh' => 'passport.api.v1.refresh-token',
        'user' => 'passport.api.v1.user',
        'check' => 'passport.api.v1.check-login',
        'logout' => 'passport.api.v1.logout',
    ],
    'user' => \CrCms\App\User::class,
];