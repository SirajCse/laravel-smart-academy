<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LanguageSeeder::class,
            PermissionCategorySeeder::class,
            RoleSeeder::class,
            SessionSeeder::class,
            AttendenceTypeSeeder::class,
            SchSettingSeeder::class,
            AdminUserSeeder::class,
            SampleDataSeeder::class,
        ]);
    }
}
