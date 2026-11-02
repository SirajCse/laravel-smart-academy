<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisableReason;
use App\Http\Requests\DisableReasonRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * DisableReason controller.
 *
 * Replaces CI3 controllers/admin/DisableReasonController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.disable-reason' prefix.
 */
class DisableReasonController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.disable-reason.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.disable-reason.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.disable-reason.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.disable-reason.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = DisableReason::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.disable-reason.index', compact('records'));
    }

    public function create()
    {
        return view('admin.disable-reason.create');
    }

    public function store(DisableReasonRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = DisableReason::create($data);
            DB::commit();
            return redirect()->route('admin.disable-reason.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(DisableReason $record)
    {
        return view('admin.disable-reason.show', compact('record'));
    }

    public function edit(DisableReason $record)
    {
        return view('admin.disable-reason.edit', compact('record'));
    }

    public function update(DisableReasonRequest $request, DisableReason $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.disable-reason.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(DisableReason $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.disable-reason.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
