<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class HostelMember extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'hostel_member';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'member_id',
        'member_type',
        'hostel_room_id',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'member_id' => 'integer',
        'hostel_room_id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('hostel_member');
    }

    public function room()
    {
        return $this->belongsTo(\App\Models\HostelRoom::class, 'hostel_room_id');
    }

}
