<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Http\Requests\GradeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Grade controller.
 *
 * Replaces CI3 controllers/admin/GradeController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.grade' prefix.
 */
class GradeController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.grade.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.grade.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.grade.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.grade.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Grade::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.grade.index', compact('records'));
    }

    public function create()
    {
        return view('admin.grade.create');
    }

    public function store(GradeRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Grade::create($data);
            DB::commit();
            return redirect()->route('admin.grade.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Grade $record)
    {
        return view('admin.grade.show', compact('record'));
    }

    public function edit(Grade $record)
    {
        return view('admin.grade.edit', compact('record'));
    }

    public function update(GradeRequest $request, Grade $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.grade.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Grade $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.grade.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
