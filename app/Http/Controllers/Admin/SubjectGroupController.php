<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubjectGroup;
use App\Http\Requests\SubjectGroupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * SubjectGroup controller.
 *
 * Replaces CI3 controllers/admin/SubjectGroupController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.subject-group' prefix.
 */
class SubjectGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.subject-group.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.subject-group.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.subject-group.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.subject-group.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = SubjectGroup::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.subject-group.index', compact('records'));
    }

    public function create()
    {
        return view('admin.subject-group.create');
    }

    public function store(SubjectGroupRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = SubjectGroup::create($data);
            DB::commit();
            return redirect()->route('admin.subject-group.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(SubjectGroup $record)
    {
        return view('admin.subject-group.show', compact('record'));
    }

    public function edit(SubjectGroup $record)
    {
        return view('admin.subject-group.edit', compact('record'));
    }

    public function update(SubjectGroupRequest $request, SubjectGroup $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.subject-group.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(SubjectGroup $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.subject-group.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
