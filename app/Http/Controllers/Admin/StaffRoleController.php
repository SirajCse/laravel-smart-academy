<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffRole;
use App\Http\Requests\StaffRoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * StaffRole controller.
 *
 * Replaces CI3 controllers/admin/StaffRoleController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.staff-role' prefix.
 */
class StaffRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.staff-role.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.staff-role.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.staff-role.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.staff-role.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = StaffRole::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.staff-role.index', compact('records'));
    }

    public function create()
    {
        return view('admin.staff-role.create');
    }

    public function store(StaffRoleRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = StaffRole::create($data);
            DB::commit();
            return redirect()->route('admin.staff-role.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(StaffRole $record)
    {
        return view('admin.staff-role.show', compact('record'));
    }

    public function edit(StaffRole $record)
    {
        return view('admin.staff-role.edit', compact('record'));
    }

    public function update(StaffRoleRequest $request, StaffRole $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.staff-role.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(StaffRole $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.staff-role.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
