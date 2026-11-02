<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Http\Requests\DesignationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Designation controller.
 *
 * Replaces CI3 controllers/admin/DesignationController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.designation' prefix.
 */
class DesignationController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.designation.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.designation.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.designation.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.designation.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Designation::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.designation.index', compact('records'));
    }

    public function create()
    {
        return view('admin.designation.create');
    }

    public function store(DesignationRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Designation::create($data);
            DB::commit();
            return redirect()->route('admin.designation.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Designation $record)
    {
        return view('admin.designation.show', compact('record'));
    }

    public function edit(Designation $record)
    {
        return view('admin.designation.edit', compact('record'));
    }

    public function update(DesignationRequest $request, Designation $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.designation.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Designation $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.designation.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
