<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class HomeworkEvaluation extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'homework_evaluation';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'homework_id',
        'student_session_id',
        'evaluation',
        'marks',
        'remark',
        'file',
    ];

    protected $casts = [
        'homework_id' => 'integer',
        'student_session_id' => 'integer',
        'marks' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('homework_evaluation');
    }

    public function homework()
    {
        return $this->belongsTo(\App\Models\Homework::class, 'homework_id');
    }

    public function studentSession()
    {
        return $this->belongsTo(\App\Models\StudentSession::class, 'student_session_id');
    }

}
