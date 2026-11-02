<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplyLeave;
use App\Http\Requests\ApplyLeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ApplyLeave controller.
 *
 * Replaces CI3 controllers/admin/ApplyLeaveController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.apply-leave' prefix.
 */
class ApplyLeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.apply-leave.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.apply-leave.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.apply-leave.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.apply-leave.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = ApplyLeave::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.apply-leave.index', compact('records'));
    }

    public function create()
    {
        return view('admin.apply-leave.create');
    }

    public function store(ApplyLeaveRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = ApplyLeave::create($data);
            DB::commit();
            return redirect()->route('admin.apply-leave.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(ApplyLeave $record)
    {
        return view('admin.apply-leave.show', compact('record'));
    }

    public function edit(ApplyLeave $record)
    {
        return view('admin.apply-leave.edit', compact('record'));
    }

    public function update(ApplyLeaveRequest $request, ApplyLeave $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.apply-leave.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(ApplyLeave $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.apply-leave.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
