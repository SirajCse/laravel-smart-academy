<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Timetable extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'timetables';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'class_id',
        'section_id',
        'subject_id',
        'staff_id',
        'day',
        'start_time',
        'end_time',
        'room_no',
        'session_id',
    ];

    protected $casts = [
        'class_id' => 'integer',
        'section_id' => 'integer',
        'subject_id' => 'integer',
        'staff_id' => 'integer',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'session_id' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('timetables');
    }

    public function class()
    {
        return $this->belongsTo(\App\Models\SchoolClass::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(\App\Models\Section::class, 'section_id');
    }

    public function subject()
    {
        return $this->belongsTo(\App\Models\Subject::class, 'subject_id');
    }

    public function staff()
    {
        return $this->belongsTo(\App\Models\Staff::class, 'staff_id');
    }

}
