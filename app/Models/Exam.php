<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Exam extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'exams';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'exam_group_id',
        'name',
        'description',
        'publish_result',
        'is_active',
        'date',
    ];

    protected $casts = [
        'exam_group_id' => 'integer',
        'publish_result' => 'boolean',
        'is_active' => 'boolean',
        'date' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('exams');
    }

    public function group()
    {
        return $this->belongsTo(\App\Models\ExamGroup::class, 'exam_group_id');
    }

    public function schedules()
    {
        return $this->hasMany(\App\Models\ExamSchedule::class, 'exam_id');
    }

    public function results()
    {
        return $this->hasMany(\App\Models\ExamResult::class, 'exam_id');
    }

}
