<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class GatewayIns extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'gateway_ins';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'gateway',
        'reference_no',
        'payment_id',
        'amount',
        'currency',
        'status',
        'payload',
        'ip_address',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('gateway_ins');
    }


}
