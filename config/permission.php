<?php

/**
 * RBAC configuration — replaces CI3 `roles` + `roles_permissions` + `permission_category` tables.
 * We delegate to spatie/laravel-permission for storage but keep Smart Academy's
 * four-action (view/create/update/delete) convention.
 */

return [

    'models' => [
        'permission' => \Spatie\Permission\Models\Permission::class,
        'role'       => \Spatie\Permission\Models\Role::class,
    ],

    'table_names' => [
        'roles'               => 'roles',
        'permissions'         => 'permissions',
        'model_has_permissions'=> 'model_has_permissions',
        'model_has_roles'     => 'model_has_roles',
        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [
        'role_pivot_key'      => null,
        'permission_pivot_key'=> null,
        'model_morph_key'     => 'model_id',
        'team_foreign_key'    => 'team_id',
    ],

    // Smart Academy's super-admin role (legacy role id 7 → "Super Admin")
    'super_admin' => [
        'role_id'   => 7,
        'role_name' => 'Super Admin',
    ],

    // Four-action RBAC convention (per permission_category.short_code).
    'actions' => ['view', 'create', 'edit', 'delete'],

    'register_permission_check_helpers' => true,
    'enable_team_permissions'            => false,
    'teams'                              => false,
    'cache' => [
        'enabled'    => true,
        'store'      => 'default',
        'key'        => 'spatie.permission.cache',
        'expiration' => 86400,
    ],
];
