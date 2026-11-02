<?php

namespace Database\Seeders;

use App\Models\{SchoolClass, Section, ClassSection, FeeCategory};
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $classes = ['Class 1', 'Class 2', 'Class 3', 'Class 4', 'Class 5'];
        foreach ($classes as $name) {
            SchoolClass::create(['class' => $name, 'is_active' => 1]);
        }

        $sections = ['A', 'B', 'C'];
        foreach ($sections as $name) {
            Section::create(['section' => $name]);
        }

        foreach (SchoolClass::all() as $class) {
            foreach (Section::all() as $section) {
                ClassSection::create([
                    'class_id'   => $class->id,
                    'section_id' => $section->id,
                ]);
            }
        }

        FeeCategory::create(['name' => 'Tuition Fee']);
        FeeCategory::create(['name' => 'Transport Fee']);
        FeeCategory::create(['name' => 'Library Fee']);
        FeeCategory::create(['name' => 'Examination Fee']);
        FeeCategory::create(['name' => 'Hostel Fee']);
    }
}
