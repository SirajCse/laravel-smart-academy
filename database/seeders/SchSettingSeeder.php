<?php

namespace Database\Seeders;

use App\Models\{SchSetting, SchoolSession, Language};
use Illuminate\Database\Seeder;

class SchSettingSeeder extends Seeder
{
    public function run(): void
    {
        SchSetting::create([
            'school_name'      => 'Smart Academy',
            'school_code'      => 'SA-' . date('Y'),
            'session_id'       => SchoolSession::where('is_active', 1)->first()->id ?? 1,
            'start_month'      => 4,
            'start_week'       => 'monday',
            'lang_id'          => Language::where('short_code', 'en')->first()->id ?? 1,
            'timezone'         => config('app.timezone'),
            'theme'            => 'default',
            'is_rtl'           => 0,
            'currency'         => 'USD',
            'currency_symbol'  => '$',
            'currency_place'   => 'before',
            'date_format'      => 'd-m-Y',
            'email'            => 'info@smart-academy.local',
            'phone'            => '+1 234 567 890',
            'address'          => '123 Education Street, Learning City, Country',
            'office_hours'     => '9:00 AM - 5:00 PM',
            'copyright'        => '(c) ' . date('Y') . ' Smart Academy',
            'student_login'    => '1',
            'parent_login'     => '1',
            'staff_login'      => '1',
            'admin_login'      => '1',
            'super_admin_login'=> '1',
        ]);
    }
}
