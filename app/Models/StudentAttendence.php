<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class StudentAttendence extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'student_attendences';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'student_session_id',
        'attendence_type_id',
        'date',
        'remark',
        'biometric_attendance',
        'created_by',
    ];

    protected $casts = [
        'student_session_id' => 'integer',
        'attendence_type_id' => 'integer',
        'date' => 'date',
        'biometric_attendance' => 'boolean',
        'created_by' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('student_attendences');
    }

    public function studentSession()
    {
        return $this->belongsTo(\App\Models\StudentSession::class, 'student_session_id');
    }

    public function type()
    {
        return $this->belongsTo(\App\Models\AttendenceType::class, 'attendence_type_id');
    }

}
