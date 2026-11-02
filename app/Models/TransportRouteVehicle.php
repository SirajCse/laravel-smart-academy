<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TransportRouteVehicle extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'transport_route_vehicle';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'transport_route_id',
        'transport_vehicle_id',
    ];

    protected $casts = [
        'transport_route_id' => 'integer',
        'transport_vehicle_id' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('transport_route_vehicle');
    }

    public function route()
    {
        return $this->belongsTo(\App\Models\TransportRoute::class, 'transport_route_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(\App\Models\TransportVehicle::class, 'transport_vehicle_id');
    }

}
