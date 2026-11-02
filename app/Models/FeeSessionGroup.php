<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FeeSessionGroup extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'fee_session_groups';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'session_id',
        'fee_groups_feetype_id',
    ];

    protected $casts = [
        'session_id' => 'integer',
        'fee_groups_feetype_id' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('fee_session_groups');
    }

    public function session()
    {
        return $this->belongsTo(\App\Models\SchoolSession::class, 'session_id');
    }

    public function groupType()
    {
        return $this->belongsTo(\App\Models\FeeGroupFeetype::class, 'fee_groups_feetype_id');
    }

}
