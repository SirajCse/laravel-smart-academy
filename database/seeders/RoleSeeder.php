<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Super Admin',  'guard_name' => 'admin', 'description' => 'Full access',          'is_active' => 1, 'is_superadmin' => 1],
            ['name' => 'Admin',        'guard_name' => 'admin', 'description' => 'Admin access',         'is_active' => 1, 'is_superadmin' => 0],
            ['name' => 'Teacher',      'guard_name' => 'admin', 'description' => 'Teacher access',       'is_active' => 1, 'is_superadmin' => 0],
            ['name' => 'Accountant',   'guard_name' => 'admin', 'description' => 'Accountant access',    'is_active' => 1, 'is_superadmin' => 0],
            ['name' => 'Librarian',    'guard_name' => 'admin', 'description' => 'Librarian access',     'is_active' => 1, 'is_superadmin' => 0],
            ['name' => 'Receptionist', 'guard_name' => 'admin', 'description' => 'Receptionist access',  'is_active' => 1, 'is_superadmin' => 0],
            ['name' => 'Parent',       'guard_name' => 'student', 'description' => 'Parent access',      'is_active' => 1, 'is_superadmin' => 0],
        ];

        foreach ($roles as $role) Role::create($role);
    }
}
