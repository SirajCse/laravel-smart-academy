<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;

class Staff extends Authenticatable
{
    use HasFactory, LogsActivity, HasApiTokens, Notifiable, HasRoles;

    protected $table = 'staff';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $guard_name = 'admin';

    protected $fillable = [
        'staff_id', 'role', 'department_id', 'designation_id',
        'name', 'email', 'phone', 'emergency_phone', 'gender', 'image',
        'dob', 'joining_date', 'leaving_date', 'address', 'qualification',
        'work_experience', 'note', 'facebook', 'twitter', 'linkedin',
        'instagram', 'resume', 'joining_letter', 'documents', 'signature',
        'salary', 'account_number', 'bank_name', 'ifsc_code', 'bank_branch',
        'epf_number', 'basic_salary', 'work_shift', 'work_location',
        'is_active', 'password', 'last_login', 'language_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
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
        'last_login' => 'datetime',
        'language_id' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('staff');
    }

    public function findForPassport(string $identifier): ?self
    {
        return static::where('email', $identifier)
            ->orWhere('phone', $identifier)
            ->orWhere('staff_id', $identifier)
            ->first();
    }

    public function staffRoles()
    {
        return $this->hasMany(StaffRole::class, 'staff_id');
    }

    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class, 'department_id');
    }

    public function designation()
    {
        return $this->belongsTo(\App\Models\Designation::class, 'designation_id');
    }

    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'staff_roles', 'staff_id', 'role_id');
    }
}
