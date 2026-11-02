<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ExamGroupStudent extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'exam_group_class_batch_exam_students';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'exam_group_id',
        'student_session_id',
    ];

    protected $casts = [
        'exam_group_id' => 'integer',
        'student_session_id' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('exam_group_class_batch_exam_students');
    }

    public function group()
    {
        return $this->belongsTo(\App\Models\ExamGroup::class, 'exam_group_id');
    }

    public function studentSession()
    {
        return $this->belongsTo(\App\Models\StudentSession::class, 'student_session_id');
    }

}
