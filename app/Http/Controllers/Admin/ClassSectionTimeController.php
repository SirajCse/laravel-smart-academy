<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassSectionTime;
use App\Http\Requests\ClassSectionTimeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ClassSectionTime controller.
 *
 * Replaces CI3 controllers/admin/ClassSectionTimeController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.class-section-time' prefix.
 */
class ClassSectionTimeController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.class-section-time.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.class-section-time.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.class-section-time.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.class-section-time.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = ClassSectionTime::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.class-section-time.index', compact('records'));
    }

    public function create()
    {
        return view('admin.class-section-time.create');
    }

    public function store(ClassSectionTimeRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = ClassSectionTime::create($data);
            DB::commit();
            return redirect()->route('admin.class-section-time.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(ClassSectionTime $record)
    {
        return view('admin.class-section-time.show', compact('record'));
    }

    public function edit(ClassSectionTime $record)
    {
        return view('admin.class-section-time.edit', compact('record'));
    }

    public function update(ClassSectionTimeRequest $request, ClassSectionTime $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.class-section-time.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(ClassSectionTime $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.class-section-time.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
