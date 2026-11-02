<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Role controller.
 *
 * Replaces CI3 controllers/admin/RoleController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.role' prefix.
 */
class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.role.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.role.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.role.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.role.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Role::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.role.index', compact('records'));
    }

    public function create()
    {
        return view('admin.role.create');
    }

    public function store(RoleRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Role::create($data);
            DB::commit();
            return redirect()->route('admin.role.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Role $record)
    {
        return view('admin.role.show', compact('record'));
    }

    public function edit(Role $record)
    {
        return view('admin.role.edit', compact('record'));
    }

    public function update(RoleRequest $request, Role $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.role.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Role $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.role.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
