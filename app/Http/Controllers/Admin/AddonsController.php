<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Http\Requests\AddonRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Addon controller.
 *
 * Replaces CI3 controllers/admin/AddonsController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.addons' prefix.
 */
class AddonsController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.addons.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.addons.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.addons.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.addons.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Addon::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.addons.index', compact('records'));
    }

    public function create()
    {
        return view('admin.addons.create');
    }

    public function store(AddonRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Addon::create($data);
            DB::commit();
            return redirect()->route('admin.addons.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Addon $record)
    {
        return view('admin.addons.show', compact('record'));
    }

    public function edit(Addon $record)
    {
        return view('admin.addons.edit', compact('record'));
    }

    public function update(AddonRequest $request, Addon $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.addons.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Addon $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.addons.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
