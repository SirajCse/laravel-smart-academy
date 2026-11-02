<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamGroupStudent;
use App\Http\Requests\ExamGroupStudentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ExamGroupStudent controller.
 *
 * Replaces CI3 controllers/admin/ExamstudentController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.examstudent' prefix.
 */
class ExamstudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.examstudent.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.examstudent.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.examstudent.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.examstudent.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = ExamGroupStudent::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.examstudent.index', compact('records'));
    }

    public function create()
    {
        return view('admin.examstudent.create');
    }

    public function store(ExamGroupStudentRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = ExamGroupStudent::create($data);
            DB::commit();
            return redirect()->route('admin.examstudent.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(ExamGroupStudent $record)
    {
        return view('admin.examstudent.show', compact('record'));
    }

    public function edit(ExamGroupStudent $record)
    {
        return view('admin.examstudent.edit', compact('record'));
    }

    public function update(ExamGroupStudentRequest $request, ExamGroupStudent $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.examstudent.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(ExamGroupStudent $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.examstudent.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
