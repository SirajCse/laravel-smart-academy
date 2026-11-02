<?php

namespace App\Services;

use App\Models\{
    Staff,
    Role,
    StaffRole,
    PermissionCategory,
    RolesPermission,
};
use Illuminate\Support\Facades\Cache;

/**
 * RBAC service — replaces CI3's `Rbac` library.
 *
 * Maps the four-action RBAC convention from the original CI3 project:
 *   `can_view`, `can_add`, `can_edit`, `can_delete`
 * onto Laravel permission strings:
 *   `<category>.view`, `<category>.create`, `<category>.edit`, `<category>.delete`
 *
 * Spatie/laravel-permission is used for storage and lookups; this service
 * bridges the legacy `roles_permissions` table to Spatie's permission
 * resolution so old CI3 seed data continues to work.
 */
class RbacService
{
    private const SUPER_ADMIN_ROLE_ID = 7;

    /**
     * Check if the given staff has the named permission.
     *
     * @param  Staff|null  $staff  Pass null to use the currently authenticated staff.
     */
    public function hasPermission(string $permission, ?Staff $staff = null): bool
    {
        $staff ??= auth('admin')->user();
        if (! $staff) return false;

        if ($this->isSuperAdmin($staff)) return true;

        // Use spatie/laravel-permission's direct check
        return $staff->can($permission);
    }

    public function hasPrivilege(string $category, string $action): bool
    {
        $actionMap = [
            'view'   => 'view',
            'add'    => 'create',
            'create' => 'create',
            'edit'   => 'edit',
            'delete' => 'delete',
        ];
        $perm = $category . '.' . ($actionMap[$action] ?? $action);
        return $this->hasPermission($perm);
    }

    public function hasRole(string $roleName, ?Staff $staff = null): bool
    {
        $staff ??= auth('admin')->user();
        if (! $staff) return false;
        return $staff->hasRole($roleName);
    }

    public function isSuperAdmin(?Staff $staff = null): bool
    {
        $staff ??= auth('admin')->user();
        if (! $staff) return false;

        // Quick check: super-admin role name
        if ($staff->hasRole(config('permission.super_admin.role_name', 'Super Admin'))) {
            return true;
        }

        // Legacy check: role id 7 (super admin) attached to staff
        return $staff->roles()->where('roles.id', self::SUPER_ADMIN_ROLE_ID)->exists();
    }

    /**
     * Sync permissions for a role from the legacy CI3 `roles_permissions`
     * table into spatie/laravel-permission.
     */
    public function syncRolePermissions(int $roleId): void
    {
        $role = Role::findOrFail($roleId);
        $role->syncPermissions([]);

        $rows = RolesPermission::where('role_id', $roleId)->get();
        foreach ($rows as $row) {
            $category = PermissionCategory::find($row->permission_category_id);
            if (! $category) continue;
            $shortCode = $category->short_code;

            foreach (['can_view', 'can_add', 'can_edit', 'can_delete'] as $ciAction => $enabled) {
                if ($row->{$ciAction}) {
                    $actionMap = ['can_view' => 'view', 'can_add' => 'create', 'can_edit' => 'edit', 'can_delete' => 'delete'];
                    $permName = $shortCode . '.' . $actionMap[$ciAction];
                    $perm = \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permName]);
                    $role->givePermissionTo($perm);
                }
            }
        }

        Cache::forget("spatie.permission.cache");
    }
}
