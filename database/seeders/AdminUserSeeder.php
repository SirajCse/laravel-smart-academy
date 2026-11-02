<?php

namespace Database\Seeders;

use App\Models\{User, Staff, Role};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (Role::count() === 0) {
            $this->call(RoleSeeder::class);
        }

        $staff = Staff::create([
            'name'         => 'Super Admin',
            'email'        => 'admin@smart-academy.local',
            'phone'        => '+1 234 567 890',
            'password'     => Hash::make('admin123'),
            'gender'       => 'male',
            'joining_date' => today(),
            'is_active'    => 1,
            'language_id'  => 1,
        ]);

        $superAdminRole = Role::where('is_superadmin', 1)->first();
        if ($superAdminRole) {
            DB::table('staff_roles')->insert([
                'staff_id' => $staff->id,
                'role_id'  => $superAdminRole->id,
            ]);
        }

        User::create([
            'role'        => 'admin',
            'username'    => 'admin',
            'password'    => Hash::make('admin123'),
            'user_id'     => $staff->id,
            'name'        => 'Super Admin',
            'email'       => 'admin@smart-academy.local',
            'is_active'   => 1,
            'is_verified' => 1,
        ]);
    }
}
