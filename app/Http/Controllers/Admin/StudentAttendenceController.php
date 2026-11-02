<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentAttendence;
use App\Http\Requests\StudentAttendenceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * StudentAttendence controller.
 *
 * Replaces CI3 controllers/admin/StudentAttendenceController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.student-attendence' prefix.
 */
class StudentAttendenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.student-attendence.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.student-attendence.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.student-attendence.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.student-attendence.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = StudentAttendence::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.student-attendence.index', compact('records'));
    }

    public function create()
    {
        return view('admin.student-attendence.create');
    }

    public function store(StudentAttendenceRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = StudentAttendence::create($data);
            DB::commit();
            return redirect()->route('admin.student-attendence.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(StudentAttendence $record)
    {
        return view('admin.student-attendence.show', compact('record'));
    }

    public function edit(StudentAttendence $record)
    {
        return view('admin.student-attendence.edit', compact('record'));
    }

    public function update(StudentAttendenceRequest $request, StudentAttendence $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.student-attendence.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(StudentAttendence $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.student-attendence.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
