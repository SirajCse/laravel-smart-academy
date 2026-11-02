<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamSchedule;
use App\Http\Requests\ExamScheduleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ExamSchedule controller.
 *
 * Replaces CI3 controllers/admin/ExamscheduleController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.examschedule' prefix.
 */
class ExamscheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.examschedule.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.examschedule.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.examschedule.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.examschedule.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = ExamSchedule::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.examschedule.index', compact('records'));
    }

    public function create()
    {
        return view('admin.examschedule.create');
    }

    public function store(ExamScheduleRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = ExamSchedule::create($data);
            DB::commit();
            return redirect()->route('admin.examschedule.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(ExamSchedule $record)
    {
        return view('admin.examschedule.show', compact('record'));
    }

    public function edit(ExamSchedule $record)
    {
        return view('admin.examschedule.edit', compact('record'));
    }

    public function update(ExamScheduleRequest $request, ExamSchedule $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.examschedule.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(ExamSchedule $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.examschedule.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
