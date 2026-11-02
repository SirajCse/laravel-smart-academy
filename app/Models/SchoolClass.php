<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SchoolClass extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'classes';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'class',
        'note',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('classes');
    }

    public function sections()
    {
        return $this->hasMany(\App\Models\ClassSection::class, 'class_id');
    }

    public function students()
    {
        // Students are linked to classes through student_session pivot
        return $this->hasManyThrough(
            \App\Models\Student::class,
            \App\Models\StudentSession::class,
            'class_id',
            'id',
            'id',
            'student_id'
        );
    }

}
