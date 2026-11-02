<?php

namespace Database\Seeders;

use App\Models\SchoolSession;
use Illuminate\Database\Seeder;

class SessionSeeder extends Seeder
{
    public function run(): void
    {
        $sessions = [
            ['session' => (date('Y')-1) . '-' . date('Y'),     'is_active' => 0],
            ['session' => date('Y') . '-' . (date('Y')+1),     'is_active' => 1],
        ];
        foreach ($sessions as $s) SchoolSession::create($s);
    }
}
