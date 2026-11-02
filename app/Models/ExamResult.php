<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ExamResult extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'exam_results';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'exam_schedule_id',
        'student_session_id',
        'get_marks',
        'note',
        'is_absent',
    ];

    protected $casts = [
        'exam_schedule_id' => 'integer',
        'student_session_id' => 'integer',
        'get_marks' => 'decimal:2',
        'is_absent' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('exam_results');
    }

    public function schedule()
    {
        return $this->belongsTo(\App\Models\ExamSchedule::class, 'exam_schedule_id');
    }

    public function studentSession()
    {
        return $this->belongsTo(\App\Models\StudentSession::class, 'student_session_id');
    }

}
