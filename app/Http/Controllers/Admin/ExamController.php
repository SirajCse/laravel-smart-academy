<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Http\Requests\ExamRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Exam controller.
 *
 * Replaces CI3 controllers/admin/ExamController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.exam' prefix.
 */
class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.exam.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.exam.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.exam.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.exam.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Exam::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.exam.index', compact('records'));
    }

    public function create()
    {
        return view('admin.exam.create');
    }

    public function store(ExamRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Exam::create($data);
            DB::commit();
            return redirect()->route('admin.exam.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Exam $record)
    {
        return view('admin.exam.show', compact('record'));
    }

    public function edit(Exam $record)
    {
        return view('admin.exam.edit', compact('record'));
    }

    public function update(ExamRequest $request, Exam $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.exam.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Exam $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.exam.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
