<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamSubject;
use App\Http\Requests\ExamSubjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ExamSubject controller.
 *
 * Replaces CI3 controllers/admin/ExamsubjectController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.examsubject' prefix.
 */
class ExamsubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.examsubject.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.examsubject.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.examsubject.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.examsubject.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = ExamSubject::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.examsubject.index', compact('records'));
    }

    public function create()
    {
        return view('admin.examsubject.create');
    }

    public function store(ExamSubjectRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = ExamSubject::create($data);
            DB::commit();
            return redirect()->route('admin.examsubject.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(ExamSubject $record)
    {
        return view('admin.examsubject.show', compact('record'));
    }

    public function edit(ExamSubject $record)
    {
        return view('admin.examsubject.edit', compact('record'));
    }

    public function update(ExamSubjectRequest $request, ExamSubject $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.examsubject.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(ExamSubject $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.examsubject.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
