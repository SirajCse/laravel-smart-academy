<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SubjectGroupSubject extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'subject_group_subjects';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'subject_group_id',
        'subject_id',
    ];

    protected $casts = [
        'subject_group_id' => 'integer',
        'subject_id' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('subject_group_subjects');
    }

    public function group()
    {
        return $this->belongsTo(\App\Models\SubjectGroup::class, 'subject_group_id');
    }

    public function subject()
    {
        return $this->belongsTo(\App\Models\Subject::class, 'subject_id');
    }

}
