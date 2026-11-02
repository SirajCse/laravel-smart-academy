<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeacherSubject;
use App\Http\Requests\TeacherSubjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * TeacherSubject controller.
 *
 * Replaces CI3 controllers/admin/TeacherSubjectController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.teacher-subject' prefix.
 */
class TeacherSubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.teacher-subject.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.teacher-subject.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.teacher-subject.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.teacher-subject.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = TeacherSubject::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.teacher-subject.index', compact('records'));
    }

    public function create()
    {
        return view('admin.teacher-subject.create');
    }

    public function store(TeacherSubjectRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = TeacherSubject::create($data);
            DB::commit();
            return redirect()->route('admin.teacher-subject.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(TeacherSubject $record)
    {
        return view('admin.teacher-subject.show', compact('record'));
    }

    public function edit(TeacherSubject $record)
    {
        return view('admin.teacher-subject.edit', compact('record'));
    }

    public function update(TeacherSubjectRequest $request, TeacherSubject $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.teacher-subject.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(TeacherSubject $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.teacher-subject.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
