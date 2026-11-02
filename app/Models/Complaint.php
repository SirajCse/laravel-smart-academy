<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Complaint extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'complaints';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'complaint_type_id',
        'source',
        'name',
        'email',
        'phone',
        'date',
        'description',
        'action_taken',
        'assigned',
        'status',
    ];

    protected $casts = [
        'complaint_type_id' => 'integer',
        'date' => 'date',
        'assigned' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('complaints');
    }

    public function type()
    {
        return $this->belongsTo(\App\Models\ComplaintType::class, 'complaint_type_id');
    }

}
