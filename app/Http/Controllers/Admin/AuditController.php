<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Http\Requests\AuditRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Audit controller.
 *
 * Replaces CI3 controllers/admin/AuditController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.audit' prefix.
 */
class AuditController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.audit.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.audit.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.audit.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.audit.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Audit::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.audit.index', compact('records'));
    }

    public function create()
    {
        return view('admin.audit.create');
    }

    public function store(AuditRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Audit::create($data);
            DB::commit();
            return redirect()->route('admin.audit.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Audit $record)
    {
        return view('admin.audit.show', compact('record'));
    }

    public function edit(Audit $record)
    {
        return view('admin.audit.edit', compact('record'));
    }

    public function update(AuditRequest $request, Audit $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.audit.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Audit $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.audit.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
