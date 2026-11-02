<?php

return [
    'defaults' => [
        'guard'     => 'web',
        'passwords' => 'users',
    ],
    'guards' => [
        'web' => ['driver' => 'session', 'provider' => 'users'],
        'admin' => ['driver' => 'admin', 'provider' => 'staff'],
        'student' => ['driver' => 'student', 'provider' => 'users'],
        'sanctum' => ['driver' => 'sanctum', 'provider' => null],
    ],
    'providers' => [
        'users' => ['driver' => 'eloquent', 'model' => env('AUTH_PROVIDER_USERS_MODEL', \App\Models\User::class)],
        'staff' => ['driver' => 'eloquent', 'model' => env('AUTH_PROVIDER_STAFF_MODEL', \App\Models\Staff::class)],
    ],
    'passwords' => [
        'users' => ['provider' => 'users', 'table' => 'password_reset_tokens', 'expire' => 60, 'throttle' => 60],
        'staff' => ['provider' => 'staff', 'table' => 'password_reset_tokens', 'expire' => 60, 'throttle' => 60],
    ],
    'password_timeout' => 10800,
];
