<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TransportMember extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'transport_member';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'member_id',
        'member_type',
        'transport_route_vehicle_id',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'member_id' => 'integer',
        'transport_route_vehicle_id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('transport_member');
    }

    public function routeVehicle()
    {
        return $this->belongsTo(\App\Models\TransportRouteVehicle::class, 'transport_route_vehicle_id');
    }

}
