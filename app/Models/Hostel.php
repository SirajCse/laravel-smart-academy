<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Hostel extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'hostel';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'hostel_name',
        'hostel_type',
        'address',
        'contact_number',
        'intake',
        'description',
        'is_active',
    ];

    protected $casts = [
        'intake' => 'integer',
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('hostel');
    }

    public function rooms()
    {
        return $this->hasMany(\App\Models\HostelRoom::class, 'hostel_id');
    }

}
