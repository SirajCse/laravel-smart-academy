<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Role extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'roles';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'is_superadmin',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_superadmin' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('roles');
    }

    public function staffRoles()
    {
        return $this->hasMany(\App\Models\StaffRole::class, 'role_id');
    }

    public function permissions()
    {
        return $this->hasMany(\App\Models\RolePermission::class, 'role_id');
    }

}
