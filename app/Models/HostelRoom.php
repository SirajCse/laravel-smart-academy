<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class HostelRoom extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'hostel_rooms';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'hostel_id',
        'room_type',
        'room_no',
        'no_of_bed',
        'cost_per_bed',
        'description',
        'is_active',
    ];

    protected $casts = [
        'hostel_id' => 'integer',
        'no_of_bed' => 'integer',
        'cost_per_bed' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('hostel_rooms');
    }

    public function hostel()
    {
        return $this->belongsTo(\App\Models\Hostel::class, 'hostel_id');
    }

}
