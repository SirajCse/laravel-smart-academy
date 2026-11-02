<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class GeneralCall extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'general_call';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'call_type',
        'call_by',
        'name',
        'email',
        'phone',
        'date',
        'description',
        'follow_up_date',
        'next_follow_up_date',
        'status',
    ];

    protected $casts = [
        'call_by' => 'integer',
        'date' => 'date',
        'follow_up_date' => 'date',
        'next_follow_up_date' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('general_call');
    }


}
