<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Homework extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'homework';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'class_id',
        'section_id',
        'subject_id',
        'staff_id',
        'homework_date',
        'submit_date',
        'marks',
        'description',
        'document',
        'session_id',
    ];

    protected $casts = [
        'class_id' => 'integer',
        'section_id' => 'integer',
        'subject_id' => 'integer',
        'staff_id' => 'integer',
        'homework_date' => 'date',
        'submit_date' => 'date',
        'marks' => 'decimal:2',
        'session_id' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('homework');
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

    public function evaluations()
    {
        return $this->hasMany(\App\Models\HomeworkEvaluation::class, 'homework_id');
    }

}
