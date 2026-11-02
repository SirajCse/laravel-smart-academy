<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Enquiry extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'enquiry';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'purpose',
        'source',
        'date',
        'next_follow_up_date',
        'description',
        'status',
        'assigned_to',
    ];

    protected $casts = [
        'date' => 'date',
        'next_follow_up_date' => 'date',
        'assigned_to' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('enquiry');
    }


}
