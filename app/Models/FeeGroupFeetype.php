<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FeeGroupFeetype extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'fee_groups_feetype';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'feegroup_id',
        'feetype_id',
        'amount',
        'session_id',
    ];

    protected $casts = [
        'feegroup_id' => 'integer',
        'feetype_id' => 'integer',
        'amount' => 'decimal:2',
        'session_id' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('fee_groups_feetype');
    }

    public function group()
    {
        return $this->belongsTo(\App\Models\FeeGroup::class, 'feegroup_id');
    }

    public function type()
    {
        return $this->belongsTo(\App\Models\FeeType::class, 'feetype_id');
    }

    public function session()
    {
        return $this->belongsTo(\App\Models\SchoolSession::class, 'session_id');
    }

}
