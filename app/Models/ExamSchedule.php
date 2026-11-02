<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ExamSchedule extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'exam_schedules';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'exam_id',
        'class_id',
        'section_id',
        'subject_id',
        'session_id',
        'date_of_exam',
        'start_time',
        'end_time',
        'room_no',
        'full_marks',
        'passing_marks',
    ];

    protected $casts = [
        'exam_id' => 'integer',
        'class_id' => 'integer',
        'section_id' => 'integer',
        'subject_id' => 'integer',
        'session_id' => 'integer',
        'date_of_exam' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'full_marks' => 'decimal:2',
        'passing_marks' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('exam_schedules');
    }

    public function exam()
    {
        return $this->belongsTo(\App\Models\Exam::class, 'exam_id');
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

}
