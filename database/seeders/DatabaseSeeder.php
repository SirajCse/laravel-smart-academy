<?php

namespace Database\Seeders;

use App\Models\{User, Staff, Role, PermissionCategory, SchSetting, SchoolSession, AttendenceType, Language};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            ['language' => 'English',   'short_code' => 'en', 'is_active' => 1, 'is_rtl' => 0],
            ['language' => 'Arabic',    'short_code' => 'ar', 'is_active' => 1, 'is_rtl' => 1],
            ['language' => 'Hindi',     'short_code' => 'hi', 'is_active' => 1, 'is_rtl' => 0],
            ['language' => 'Bengali',   'short_code' => 'bn', 'is_active' => 1, 'is_rtl' => 0],
            ['language' => 'Spanish',   'short_code' => 'es', 'is_active' => 1, 'is_rtl' => 0],
            ['language' => 'French',    'short_code' => 'fr', 'is_active' => 1, 'is_rtl' => 0],
            ['language' => 'German',   'short_code' => 'de', 'is_active' => 1, 'is_rtl' => 0],
            ['language' => 'Urdu',     'short_code' => 'ur', 'is_active' => 1, 'is_rtl' => 1],
            ['language' => 'Chinese',  'short_code' => 'zh', 'is_active' => 1, 'is_rtl' => 0],
        ];

        foreach ($languages as $lang) Language::create($lang);
    }
}

class PermissionCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Dashboard', 'short_code' => 'dashboard', 'parent_id' => null, 'icon' => 'fa-dashboard'],
            ['name' => 'Student', 'short_code' => 'student', 'parent_id' => null, 'icon' => 'fa-user'],
            ['name' => 'Classes', 'short_code' => 'class', 'parent_id' => null, 'icon' => 'fa-university'],
            ['name' => 'Sections', 'short_code' => 'section', 'parent_id' => null, 'icon' => 'fa-th-large'],
            ['name' => 'Sessions', 'short_code' => 'session', 'parent_id' => null, 'icon' => 'fa-calendar'],
            ['name' => 'Subjects', 'short_code' => 'subject', 'parent_id' => null, 'icon' => 'fa-book'],
            ['name' => 'Staff', 'short_code' => 'staff', 'parent_id' => null, 'icon' => 'fa-users'],
            ['name' => 'Attendance', 'short_code' => 'attendance', 'parent_id' => null, 'icon' => 'fa-check-square-o'],
            ['name' => 'Examinations', 'short_code' => 'exam', 'parent_id' => null, 'icon' => 'fa-graduation-cap'],
            ['name' => 'Homework', 'short_code' => 'homework', 'parent_id' => null, 'icon' => 'fa-pencil'],
            ['name' => 'Fees', 'short_code' => 'fees', 'parent_id' => null, 'icon' => 'fa-money'],
            ['name' => 'Income', 'short_code' => 'income', 'parent_id' => null, 'icon' => 'fa-plus-circle'],
            ['name' => 'Expense', 'short_code' => 'expense', 'parent_id' => null, 'icon' => 'fa-minus-circle'],
            ['name' => 'Library', 'short_code' => 'library', 'parent_id' => null, 'icon' => 'fa-book'],
            ['name' => 'Inventory', 'short_code' => 'inventory', 'parent_id' => null, 'icon' => 'fa-cubes'],
            ['name' => 'Transport', 'short_code' => 'transport', 'parent_id' => null, 'icon' => 'fa-bus'],
            ['name' => 'Hostel', 'short_code' => 'hostel', 'parent_id' => null, 'icon' => 'fa-bed'],
            ['name' => 'Front Office', 'short_code' => 'front_office', 'parent_id' => null, 'icon' => 'fa-phone'],
            ['name' => 'Front CMS', 'short_code' => 'front_cms', 'parent_id' => null, 'icon' => 'fa-globe'],
            ['name' => 'Reports', 'short_code' => 'reports', 'parent_id' => null, 'icon' => 'fa-file-text-o'],
            ['name' => 'Settings', 'short_code' => 'schsettings', 'parent_id' => null, 'icon' => 'fa-cogs'],
            ['name' => 'System', 'short_code' => 'system', 'parent_id' => null, 'icon' => 'fa-server'],
            ['name' => 'Audit Log', 'short_code' => 'audit', 'parent_id' => null, 'icon' => 'fa-history'],
            ['name' => 'Addons', 'short_code' => 'addons', 'parent_id' => null, 'icon' => 'fa-puzzle-piece'],
            ['name' => 'Communicate', 'short_code' => 'communicate', 'parent_id' => null, 'icon' => 'fa-envelope'],
        ];

        foreach ($categories as $cat) PermissionCategory::create($cat);
    }
}

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Super Admin', 'description' => 'Full access', 'is_active' => 1, 'is_superadmin' => 1],
            ['name' => 'Admin',       'description' => 'Admin access', 'is_active' => 1, 'is_superadmin' => 0],
            ['name' => 'Teacher',     'description' => 'Teacher access', 'is_active' => 1, 'is_superadmin' => 0],
            ['name' => 'Accountant',  'description' => 'Accountant access', 'is_active' => 1, 'is_superadmin' => 0],
            ['name' => 'Librarian',   'description' => 'Librarian access', 'is_active' => 1, 'is_superadmin' => 0],
            ['name' => 'Receptionist','description' => 'Receptionist access', 'is_active' => 1, 'is_superadmin' => 0],
            ['name' => 'Parent',      'description' => 'Parent access', 'is_active' => 1, 'is_superadmin' => 0],
        ];

        foreach ($roles as $role) Role::create($role);

        // Sync permissions for super-admin (give all permissions)
        $superAdmin = Role::where('is_superadmin', 1)->first();
        $superAdmin->givePermissionTo(['dashboard.view']);
    }
}

class SessionSeeder extends Seeder
{
    public function run(): void
    {
        $sessions = [
            ['session' => (date('Y')-1) . '-' . date('Y'), 'is_active' => 0],
            ['session' => date('Y') . '-' . (date('Y')+1), 'is_active' => 1],
        ];

        foreach ($sessions as $s) SchoolSession::create($s);
    }
}

class AttendenceTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Present', 'short_code' => 'P', 'is_active' => 1],
            ['name' => 'Absent',  'short_code' => 'A', 'is_active' => 1],
            ['name' => 'Late',    'short_code' => 'L', 'is_active' => 1],
            ['name' => 'Half Day','short_code' => 'H', 'is_active' => 1],
            ['name' => 'Holiday', 'short_code' => 'O', 'is_active' => 1],
        ];

        foreach ($types as $t) AttendenceType::create($t);
    }
}

class SchSettingSeeder extends Seeder
{
    public function run(): void
    {
        SchSetting::create([
            'school_name' => 'Smart Academy',
            'school_code' => 'SA-' . date('Y'),
            'session_id'  => SchoolSession::where('is_active', 1)->first()->id,
            'start_month' => 4,
            'start_week'  => 'monday',
            'lang_id'     => Language::where('short_code', 'en')->first()->id,
            'timezone'    => config('app.timezone'),
            'theme'       => 'default',
            'is_rtl'      => 0,
            'currency'    => 'USD',
            'currency_symbol' => '$',
            'currency_place' => 'before',
            'date_format' => 'd-m-Y',
            'email'       => 'info@smart-academy.local',
            'phone'       => '+1 234 567 890',
            'address'     => '123 Education Street, Learning City, Country',
            'office_hours'=> '9:00 AM - 5:00 PM',
            'copyright'   => '© ' . date('Y') . ' Smart Academy',
            'student_login' => '1',
            'parent_login'  => '1',
            'staff_login'   => '1',
            'admin_login'   => '1',
            'super_admin_login' => '1',
        ]);
    }
}

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create super-admin staff record
        $staff = Staff::create([
            'name'          => 'Super Admin',
            'email'         => 'admin@smart-academy.local',
            'phone'         => '+1 234 567 890',
            'password'      => Hash::make('admin123'),
            'gender'        => 'male',
            'joining_date'  => today(),
            'is_active'     => 1,
        ]);

        // Assign super-admin role
        $superAdminRole = Role::where('is_superadmin', 1)->first();
        DB::table('staff_roles')->insert([
            'staff_id' => $staff->id,
            'role_id'  => $superAdminRole->id,
        ]);

        // Create login user record (legacy CI3 behaviour)
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

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Sample classes & sections
        $classes = ['Class 1', 'Class 2', 'Class 3', 'Class 4', 'Class 5'];
        foreach ($classes as $i => $name) {
            \App\Models\SchoolClass::create(['class' => $name, 'is_active' => 1]);
        }

        $sections = ['A', 'B', 'C'];
        foreach ($sections as $name) {
            \App\Models\Section::create(['section' => $name]);
        }

        // Link classes and sections
        foreach (\App\Models\SchoolClass::all() as $class) {
            foreach (\App\Models\Section::all() as $section) {
                \App\Models\ClassSection::create([
                    'class_id' => $class->id,
                    'section_id' => $section->id,
                ]);
            }
        }

        // Sample fee categories
        \App\Models\FeeCategory::create(['name' => 'Tuition Fee']);
        \App\Models\FeeCategory::create(['name' => 'Transport Fee']);
        \App\Models\FeeCategory::create(['name' => 'Library Fee']);
        \App\Models\FeeCategory::create(['name' => 'Examination Fee']);
        \App\Models\FeeCategory::create(['name' => 'Hostel Fee']);
    }
}
