<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Http\Requests\SubjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Subject controller.
 *
 * Replaces CI3 controllers/admin/SubjectController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.subject' prefix.
 */
class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.subject.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.subject.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.subject.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.subject.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Subject::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.subject.index', compact('records'));
    }

    public function create()
    {
        return view('admin.subject.create');
    }

    public function store(SubjectRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Subject::create($data);
            DB::commit();
            return redirect()->route('admin.subject.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Subject $record)
    {
        return view('admin.subject.show', compact('record'));
    }

    public function edit(Subject $record)
    {
        return view('admin.subject.edit', compact('record'));
    }

    public function update(SubjectRequest $request, Subject $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.subject.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Subject $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.subject.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
