<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermissionCategory;
use App\Http\Requests\PermissionCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * PermissionCategory controller.
 *
 * Replaces CI3 controllers/admin/PermissionController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.permission' prefix.
 */
class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.permission.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.permission.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.permission.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.permission.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = PermissionCategory::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.permission.index', compact('records'));
    }

    public function create()
    {
        return view('admin.permission.create');
    }

    public function store(PermissionCategoryRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = PermissionCategory::create($data);
            DB::commit();
            return redirect()->route('admin.permission.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(PermissionCategory $record)
    {
        return view('admin.permission.show', compact('record'));
    }

    public function edit(PermissionCategory $record)
    {
        return view('admin.permission.edit', compact('record'));
    }

    public function update(PermissionCategoryRequest $request, PermissionCategory $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.permission.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(PermissionCategory $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.permission.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
