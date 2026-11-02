<?php

namespace Database\Seeders;

use App\Models\PermissionCategory;
use Illuminate\Database\Seeder;

class PermissionCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Dashboard',       'short_code' => 'dashboard',     'parent_id' => null, 'icon' => 'fa-dashboard'],
            ['name' => 'Student',         'short_code' => 'student',       'parent_id' => null, 'icon' => 'fa-user'],
            ['name' => 'Classes',         'short_code' => 'class',          'parent_id' => null, 'icon' => 'fa-university'],
            ['name' => 'Sections',        'short_code' => 'section',        'parent_id' => null, 'icon' => 'fa-th-large'],
            ['name' => 'Sessions',        'short_code' => 'session',        'parent_id' => null, 'icon' => 'fa-calendar'],
            ['name' => 'Subjects',        'short_code' => 'subject',        'parent_id' => null, 'icon' => 'fa-book'],
            ['name' => 'Staff',           'short_code' => 'staff',          'parent_id' => null, 'icon' => 'fa-users'],
            ['name' => 'Attendance',      'short_code' => 'attendance',     'parent_id' => null, 'icon' => 'fa-check-square-o'],
            ['name' => 'Examinations',    'short_code' => 'exam',            'parent_id' => null, 'icon' => 'fa-graduation-cap'],
            ['name' => 'Homework',        'short_code' => 'homework',        'parent_id' => null, 'icon' => 'fa-pencil'],
            ['name' => 'Fees',            'short_code' => 'fees',            'parent_id' => null, 'icon' => 'fa-money'],
            ['name' => 'Income',          'short_code' => 'income',         'parent_id' => null, 'icon' => 'fa-plus-circle'],
            ['name' => 'Expense',         'short_code' => 'expense',        'parent_id' => null, 'icon' => 'fa-minus-circle'],
            ['name' => 'Library',         'short_code' => 'library',         'parent_id' => null, 'icon' => 'fa-book'],
            ['name' => 'Inventory',        'short_code' => 'inventory',       'parent_id' => null, 'icon' => 'fa-cubes'],
            ['name' => 'Transport',       'short_code' => 'transport',       'parent_id' => null, 'icon' => 'fa-bus'],
            ['name' => 'Hostel',          'short_code' => 'hostel',          'parent_id' => null, 'icon' => 'fa-bed'],
            ['name' => 'Front Office',    'short_code' => 'front_office',   'parent_id' => null, 'icon' => 'fa-phone'],
            ['name' => 'Front CMS',       'short_code' => 'front_cms',      'parent_id' => null, 'icon' => 'fa-globe'],
            ['name' => 'Reports',         'short_code' => 'reports',        'parent_id' => null, 'icon' => 'fa-file-text-o'],
            ['name' => 'Settings',        'short_code' => 'schsettings',    'parent_id' => null, 'icon' => 'fa-cogs'],
            ['name' => 'System',          'short_code' => 'system',         'parent_id' => null, 'icon' => 'fa-server'],
            ['name' => 'Audit Log',       'short_code' => 'audit',          'parent_id' => null, 'icon' => 'fa-history'],
            ['name' => 'Addons',          'short_code' => 'addons',         'parent_id' => null, 'icon' => 'fa-puzzle-piece'],
            ['name' => 'Communicate',     'short_code' => 'communicate',    'parent_id' => null, 'icon' => 'fa-envelope'],
        ];
        foreach ($categories as $cat) PermissionCategory::create($cat);
    }
}
