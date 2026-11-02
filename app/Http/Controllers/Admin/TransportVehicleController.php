<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransportVehicle;
use App\Http\Requests\TransportVehicleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * TransportVehicle controller.
 *
 * Replaces CI3 controllers/admin/TransportVehicleController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.transport-vehicle' prefix.
 */
class TransportVehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.transport-vehicle.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.transport-vehicle.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.transport-vehicle.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.transport-vehicle.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = TransportVehicle::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.transport-vehicle.index', compact('records'));
    }

    public function create()
    {
        return view('admin.transport-vehicle.create');
    }

    public function store(TransportVehicleRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = TransportVehicle::create($data);
            DB::commit();
            return redirect()->route('admin.transport-vehicle.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(TransportVehicle $record)
    {
        return view('admin.transport-vehicle.show', compact('record'));
    }

    public function edit(TransportVehicle $record)
    {
        return view('admin.transport-vehicle.edit', compact('record'));
    }

    public function update(TransportVehicleRequest $request, TransportVehicle $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.transport-vehicle.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(TransportVehicle $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.transport-vehicle.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
