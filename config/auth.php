<?php

return [
    'defaults' => [
        'guard'     => 'web',
        'passwords' => 'users',
    ],
	'guards' => [
		'admin'   => ['driver' => 'admin',   'provider' => 'users'],
		'student' => ['driver' => 'student', 'provider' => 'students'],
	],
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
];
