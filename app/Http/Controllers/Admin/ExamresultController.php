<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamResult;
use App\Http\Requests\ExamResultRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ExamResult controller.
 *
 * Replaces CI3 controllers/admin/ExamresultController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.examresult' prefix.
 */
class ExamresultController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.examresult.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.examresult.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.examresult.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.examresult.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = ExamResult::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.examresult.index', compact('records'));
    }

    public function create()
    {
        return view('admin.examresult.create');
    }

    public function store(ExamResultRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = ExamResult::create($data);
            DB::commit();
            return redirect()->route('admin.examresult.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(ExamResult $record)
    {
        return view('admin.examresult.show', compact('record'));
    }

    public function edit(ExamResult $record)
    {
        return view('admin.examresult.edit', compact('record'));
    }

    public function update(ExamResultRequest $request, ExamResult $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.examresult.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(ExamResult $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.examresult.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
