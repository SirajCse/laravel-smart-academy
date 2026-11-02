<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeGroup;
use App\Http\Requests\FeeGroupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * FeeGroup controller.
 *
 * Replaces CI3 controllers/admin/FeegroupController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.feegroup' prefix.
 */
class FeegroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.feegroup.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.feegroup.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.feegroup.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.feegroup.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = FeeGroup::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.feegroup.index', compact('records'));
    }

    public function create()
    {
        return view('admin.feegroup.create');
    }

    public function store(FeeGroupRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = FeeGroup::create($data);
            DB::commit();
            return redirect()->route('admin.feegroup.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(FeeGroup $record)
    {
        return view('admin.feegroup.show', compact('record'));
    }

    public function edit(FeeGroup $record)
    {
        return view('admin.feegroup.edit', compact('record'));
    }

    public function update(FeeGroupRequest $request, FeeGroup $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.feegroup.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(FeeGroup $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.feegroup.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
