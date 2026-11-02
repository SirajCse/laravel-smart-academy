<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Http\Requests\SectionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Section controller.
 *
 * Replaces CI3 controllers/admin/SectionController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.section' prefix.
 */
class SectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.section.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.section.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.section.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.section.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Section::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.section.index', compact('records'));
    }

    public function create()
    {
        return view('admin.section.create');
    }

    public function store(SectionRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Section::create($data);
            DB::commit();
            return redirect()->route('admin.section.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Section $record)
    {
        return view('admin.section.show', compact('record'));
    }

    public function edit(Section $record)
    {
        return view('admin.section.edit', compact('record'));
    }

    public function update(SectionRequest $request, Section $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.section.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Section $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.section.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
