<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SubjectGroup extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'subject_groups';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'name',
        'class_id',
        'session_id',
    ];

    protected $casts = [
        'class_id' => 'integer',
        'session_id' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('subject_groups');
    }

    public function class()
    {
        return $this->belongsTo(\App\Models\SchoolClass::class, 'class_id');
    }

    public function session()
    {
        return $this->belongsTo(\App\Models\SchoolSession::class, 'session_id');
    }

}
