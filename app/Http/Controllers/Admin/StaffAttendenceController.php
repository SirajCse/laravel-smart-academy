<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffAttendance;
use App\Http\Requests\StaffAttendanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * StaffAttendance controller.
 *
 * Replaces CI3 controllers/admin/StaffAttendenceController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.staff-attendence' prefix.
 */
class StaffAttendenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.staff-attendence.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.staff-attendence.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.staff-attendence.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.staff-attendence.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = StaffAttendance::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.staff-attendence.index', compact('records'));
    }

    public function create()
    {
        return view('admin.staff-attendence.create');
    }

    public function store(StaffAttendanceRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = StaffAttendance::create($data);
            DB::commit();
            return redirect()->route('admin.staff-attendence.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(StaffAttendance $record)
    {
        return view('admin.staff-attendence.show', compact('record'));
    }

    public function edit(StaffAttendance $record)
    {
        return view('admin.staff-attendence.edit', compact('record'));
    }

    public function update(StaffAttendanceRequest $request, StaffAttendance $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.staff-attendence.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(StaffAttendance $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.staff-attendence.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
