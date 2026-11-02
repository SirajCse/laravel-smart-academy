<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class RolePermission extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'roles_permissions';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'role_id',
        'permission_category_id',
        'can_view',
        'can_add',
        'can_edit',
        'can_delete',
    ];

    protected $casts = [
        'role_id' => 'integer',
        'permission_category_id' => 'integer',
        'can_view' => 'boolean',
        'can_add' => 'boolean',
        'can_edit' => 'boolean',
        'can_delete' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('roles_permissions');
    }

    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class, 'role_id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\PermissionCategory::class, 'permission_category_id');
    }

}
