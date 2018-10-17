<?php

return [
    'key' => env('PASSPORT_KEY', null),
    'secret' => env('PASSPORT_SECRET', null),
    'routes' => [
        'login' => '/api/v1/login',
        'refresh' => '/api/v1/refresh-token',
        'user' => '/api/v1/user',
        'check' => '/api/v1/check-login',
        'logout' => '/api/v1/logout',
    ],
    'user' => \CrCms\App\User::class,
];