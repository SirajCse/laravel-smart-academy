<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Http\Requests\InventoryItemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * InventoryItem controller.
 *
 * Replaces CI3 controllers/admin/InventoryController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.inventory' prefix.
 */
class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.inventory.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.inventory.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.inventory.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.inventory.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = InventoryItem::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.inventory.index', compact('records'));
    }

    public function create()
    {
        return view('admin.inventory.create');
    }

    public function store(InventoryItemRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = InventoryItem::create($data);
            DB::commit();
            return redirect()->route('admin.inventory.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(InventoryItem $record)
    {
        return view('admin.inventory.show', compact('record'));
    }

    public function edit(InventoryItem $record)
    {
        return view('admin.inventory.edit', compact('record'));
    }

    public function update(InventoryItemRequest $request, InventoryItem $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.inventory.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(InventoryItem $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.inventory.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
