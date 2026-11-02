<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassTeacher;
use App\Http\Requests\ClassTeacherRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ClassTeacher controller.
 *
 * Replaces CI3 controllers/admin/ClassTeacherController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.class-teacher' prefix.
 */
class ClassTeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.class-teacher.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.class-teacher.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.class-teacher.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.class-teacher.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = ClassTeacher::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.class-teacher.index', compact('records'));
    }

    public function create()
    {
        return view('admin.class-teacher.create');
    }

    public function store(ClassTeacherRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = ClassTeacher::create($data);
            DB::commit();
            return redirect()->route('admin.class-teacher.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(ClassTeacher $record)
    {
        return view('admin.class-teacher.show', compact('record'));
    }

    public function edit(ClassTeacher $record)
    {
        return view('admin.class-teacher.edit', compact('record'));
    }

    public function update(ClassTeacherRequest $request, ClassTeacher $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.class-teacher.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(ClassTeacher $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.class-teacher.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
