<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ComplaintType extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'complaint_types';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'complaint_type',
        'description',
    ];

    protected $casts = [

    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('complaint_types');
    }

    public function complaints()
    {
        return $this->hasMany(\App\Models\Complaint::class, 'complaint_type_id');
    }

}
