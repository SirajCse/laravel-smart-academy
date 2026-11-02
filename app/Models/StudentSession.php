<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class StudentSession extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'student_session';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'student_id',
        'class_id',
        'section_id',
        'session_id',
        'default_login',
    ];

    protected $casts = [
        'student_id' => 'integer',
        'class_id' => 'integer',
        'section_id' => 'integer',
        'session_id' => 'integer',
        'default_login' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('student_session');
    }

    public function student()
    {
        return $this->belongsTo(\App\Models\Student::class, 'student_id');
    }

    public function class()
    {
        return $this->belongsTo(\App\Models\SchoolClass::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(\App\Models\Section::class, 'section_id');
    }

    public function session()
    {
        return $this->belongsTo(\App\Models\SchoolSession::class, 'session_id');
    }

}
