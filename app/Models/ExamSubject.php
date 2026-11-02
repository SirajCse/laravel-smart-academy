<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ExamSubject extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'exam_subjects';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'exam_group_id',
        'subject_id',
        'exam_id',
    ];

    protected $casts = [
        'exam_group_id' => 'integer',
        'subject_id' => 'integer',
        'exam_id' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('exam_subjects');
    }

    public function group()
    {
        return $this->belongsTo(\App\Models\ExamGroup::class, 'exam_group_id');
    }

    public function subject()
    {
        return $this->belongsTo(\App\Models\Subject::class, 'subject_id');
    }

    public function exam()
    {
        return $this->belongsTo(\App\Models\Exam::class, 'exam_id');
    }

}
