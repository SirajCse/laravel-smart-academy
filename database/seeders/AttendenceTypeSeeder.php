<?php

namespace Database\Seeders;

use App\Models\AttendenceType;
use Illuminate\Database\Seeder;

class AttendenceTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Present',  'short_code' => 'P', 'is_active' => 1],
            ['name' => 'Absent',   'short_code' => 'A', 'is_active' => 1],
            ['name' => 'Late',     'short_code' => 'L', 'is_active' => 1],
            ['name' => 'Half Day', 'short_code' => 'H', 'is_active' => 1],
            ['name' => 'Holiday',  'short_code' => 'O', 'is_active' => 1],
        ];
        foreach ($types as $t) AttendenceType::create($t);
    }
}
