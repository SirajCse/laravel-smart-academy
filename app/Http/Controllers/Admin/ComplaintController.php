<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Http\Requests\ComplaintRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Complaint controller.
 *
 * Replaces CI3 controllers/admin/ComplaintController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.complaint' prefix.
 */
class ComplaintController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.complaint.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.complaint.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.complaint.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.complaint.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Complaint::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.complaint.index', compact('records'));
    }

    public function create()
    {
        return view('admin.complaint.create');
    }

    public function store(ComplaintRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Complaint::create($data);
            DB::commit();
            return redirect()->route('admin.complaint.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Complaint $record)
    {
        return view('admin.complaint.show', compact('record'));
    }

    public function edit(Complaint $record)
    {
        return view('admin.complaint.edit', compact('record'));
    }

    public function update(ComplaintRequest $request, Complaint $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.complaint.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Complaint $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.complaint.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
