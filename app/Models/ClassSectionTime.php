<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ClassSectionTime extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'class_section_time';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'class_section_id',
        'day',
        'start_time',
        'end_time',
        'is_break',
    ];

    protected $casts = [
        'class_section_id' => 'integer',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_break' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('class_section_time');
    }

    public function classSection()
    {
        return $this->belongsTo(\App\Models\ClassSection::class, 'class_section_id');
    }

}
