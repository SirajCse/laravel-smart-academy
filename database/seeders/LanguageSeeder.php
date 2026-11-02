<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            ['language' => 'English',  'short_code' => 'en', 'is_active' => 1, 'is_rtl' => 0],
            ['language' => 'Arabic',   'short_code' => 'ar', 'is_active' => 1, 'is_rtl' => 1],
            ['language' => 'Hindi',    'short_code' => 'hi', 'is_active' => 1, 'is_rtl' => 0],
            ['language' => 'Bengali',  'short_code' => 'bn', 'is_active' => 1, 'is_rtl' => 0],
            ['language' => 'Spanish',  'short_code' => 'es', 'is_active' => 1, 'is_rtl' => 0],
            ['language' => 'French',   'short_code' => 'fr', 'is_active' => 1, 'is_rtl' => 0],
            ['language' => 'German',   'short_code' => 'de', 'is_active' => 1, 'is_rtl' => 0],
            ['language' => 'Urdu',     'short_code' => 'ur', 'is_active' => 1, 'is_rtl' => 1],
            ['language' => 'Chinese',  'short_code' => 'zh', 'is_active' => 1, 'is_rtl' => 0],
        ];

        foreach ($languages as $lang) Language::create($lang);
    }
}
