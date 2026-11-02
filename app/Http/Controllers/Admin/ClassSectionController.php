<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassSection;
use App\Http\Requests\ClassSectionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ClassSection controller.
 *
 * Replaces CI3 controllers/admin/ClassSectionController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.class-section' prefix.
 */
class ClassSectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.class-section.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.class-section.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.class-section.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.class-section.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = ClassSection::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.class-section.index', compact('records'));
    }

    public function create()
    {
        return view('admin.class-section.create');
    }

    public function store(ClassSectionRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = ClassSection::create($data);
            DB::commit();
            return redirect()->route('admin.class-section.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(ClassSection $record)
    {
        return view('admin.class-section.show', compact('record'));
    }

    public function edit(ClassSection $record)
    {
        return view('admin.class-section.edit', compact('record'));
    }

    public function update(ClassSectionRequest $request, ClassSection $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.class-section.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(ClassSection $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.class-section.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
