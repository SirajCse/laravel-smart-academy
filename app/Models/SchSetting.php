<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SchSetting extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'sch_settings';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'school_name',
        'school_code',
        'session_id',
        'start_month',
        'start_week',
        'lang_id',
        'timezone',
        'theme',
        'rtl',
        'is_rtl',
        'currency',
        'currency_symbol',
        'currency_place',
        'date_format',
        'phone',
        'email',
        'address',
        'logo',
        'sidebar',
        'student_login',
        'parent_login',
        'staff_login',
        'admin_login',
        'super_admin_login',
        'marksheet',
        'mobile_app_url',
        'app_primary_color',
        'app_secondary_color',
        'app_logo',
        'copyright',
        'youtube_url',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'instagram_url',
        'pinterest_url',
        'office_hours',
        'languages',
    ];

    protected $casts = [
        'session_id' => 'integer',
        'lang_id' => 'integer',
        'rtl' => 'boolean',
        'is_rtl' => 'boolean',
        'languages' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('sch_settings');
    }

    public function session()
    {
        return $this->belongsTo(\App\Models\SchoolSession::class, 'session_id');
    }

    public function language()
    {
        return $this->belongsTo(\App\Models\Language::class, 'lang_id');
    }

}
