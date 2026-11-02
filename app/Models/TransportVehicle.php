<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TransportVehicle extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'transport_vehicle';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'vehicle_no',
        'vehicle_model',
        'driver_name',
        'driver_phone',
        'vehicle_fee',
        'capacity',
        'description',
        'is_active',
    ];

    protected $casts = [
        'vehicle_fee' => 'decimal:2',
        'capacity' => 'integer',
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('transport_vehicle');
    }


}
