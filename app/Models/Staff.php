<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Staff extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'staff';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'staff_id',
        'role',
        'department_id',
        'designation_id',
        'name',
        'email',
        'phone',
        'emergency_phone',
        'gender',
        'image',
        'dob',
        'joining_date',
        'leaving_date',
        'address',
        'qualification',
        'work_experience',
        'note',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'resume',
        'joining_letter',
        'documents',
        'signature',
        'salary',
        'account_number',
        'bank_name',
        'ifsc_code',
        'bank_branch',
        'epf_number',
        'basic_salary',
        'work_shift',
        'work_location',
        'is_active',
    ];

    protected $casts = [
        'department_id' => 'integer',
        'designation_id' => 'integer',
        'dob' => 'date',
        'joining_date' => 'date',
        'leaving_date' => 'date',
        'salary' => 'decimal:2',
        'basic_salary' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('staff');
    }

    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class, 'department_id');
    }

    public function designation()
    {
        return $this->belongsTo(\App\Models\Designation::class, 'designation_id');
    }

    public function roles()
    {
        return $this->hasMany(\App\Models\StaffRole::class, 'staff_id');
    }

    public function attendances()
    {
        return $this->hasMany(\App\Models\StaffAttendance::class, 'staff_id');
    }

}
