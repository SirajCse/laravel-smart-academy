<?php

/**
 * Smart Academy module configuration.
 *
 * Replaces CI3's per-module autoload. Each module is wired with its
 * own provider, routes file, and view namespace.
 */

return [

    'default' => 'smart-academy',

    'modules' => [

        'smart-academy' => [
            'enabled'       => true,
            'namespace'     => 'App\\',
            'path'          => app_path(),
            'providers'     => [],
            'routes'        => [
                'web' => base_path('routes/web.php'),
                'api' => base_path('routes/api.php'),
            ],
            'views'         => resource_path('views'),
            'lang'          => lang_path(),
            'migrations'    => database_path('migrations'),
        ],

        // Front-CMS module (8 themes from the original project).
        'front-cms' => [
            'enabled'       => true,
            'namespace'     => 'App\\Front\\',
            'path'          => app_path('Front'),
            'providers'     => [\App\Front\Providers\FrontServiceProvider::class],
            'routes'        => [base_path('routes/front.php')],
            'views'         => resource_path('views/front'),
            'themes_path'   => resource_path('views/themes'),
            'default_theme' => env('FRONT_CMS_THEME', 'default'),
        ],
    ],

    // Modules discovered from database (installed plugins come from `addons` table)
    'discover_from_db' => true,
    'addons_table'     => 'addons',
    'addons_path'      => base_path('addons'),
];
