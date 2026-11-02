<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PermissionCategory extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'permission_category';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'name',
        'short_code',
        'icon',
        'parent_id',
    ];

    protected $casts = [
        'parent_id' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('permission_category');
    }

    public function parent()
    {
        return $this->belongsTo(PermissionCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(PermissionCategory::class, 'parent_id');
    }

    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class, 'permission_category_id');
    }
}
