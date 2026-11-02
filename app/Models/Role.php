<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Role extends SpatieRole
{
    use HasFactory, LogsActivity;

    protected $table = 'roles';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'name', 'guard_name', 'description', 'is_active', 'is_superadmin',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_superadmin' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id', 'name'])
            ->logOnlyDirty()
            ->useLogName('roles');
    }
}
