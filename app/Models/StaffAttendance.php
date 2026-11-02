<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class StaffAttendance extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'staff_attendance';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'staff_id',
        'attendence_type_id',
        'date',
        'remark',
        'biometric_attendance',
    ];

    protected $casts = [
        'staff_id' => 'integer',
        'attendence_type_id' => 'integer',
        'date' => 'date',
        'biometric_attendance' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('staff_attendance');
    }

    public function staff()
    {
        return $this->belongsTo(\App\Models\Staff::class, 'staff_id');
    }

    public function type()
    {
        return $this->belongsTo(\App\Models\AttendenceType::class, 'attendence_type_id');
    }

}
