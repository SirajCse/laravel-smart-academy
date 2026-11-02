<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RolePermission;
use App\Http\Requests\RolePermissionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * RolePermission controller.
 *
 * Replaces CI3 controllers/admin/RolePermissionController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.role-permission' prefix.
 */
class RolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.role-permission.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.role-permission.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.role-permission.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.role-permission.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = RolePermission::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.role_permission.index', compact('records'));
    }

    public function create()
    {
        return view('admin.role_permission.create');
    }

    public function store(RolePermissionRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = RolePermission::create($data);
            DB::commit();
            return redirect()->route('admin.role-permission.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(RolePermission $record)
    {
        return view('admin.role_permission.show', compact('record'));
    }

    public function edit(RolePermission $record)
    {
        return view('admin.role_permission.edit', compact('record'));
    }

    public function update(RolePermissionRequest $request, RolePermission $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.role-permission.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(RolePermission $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.role-permission.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
