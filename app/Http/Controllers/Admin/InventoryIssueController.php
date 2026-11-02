<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemIssue;
use App\Http\Requests\ItemIssueRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ItemIssue controller.
 *
 * Replaces CI3 controllers/admin/InventoryIssueController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.inventory-issue' prefix.
 */
class InventoryIssueController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.inventory-issue.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.inventory-issue.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.inventory-issue.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.inventory-issue.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = ItemIssue::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.inventory-issue.index', compact('records'));
    }

    public function create()
    {
        return view('admin.inventory-issue.create');
    }

    public function store(ItemIssueRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = ItemIssue::create($data);
            DB::commit();
            return redirect()->route('admin.inventory-issue.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(ItemIssue $record)
    {
        return view('admin.inventory-issue.show', compact('record'));
    }

    public function edit(ItemIssue $record)
    {
        return view('admin.inventory-issue.edit', compact('record'));
    }

    public function update(ItemIssueRequest $request, ItemIssue $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.inventory-issue.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(ItemIssue $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.inventory-issue.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
