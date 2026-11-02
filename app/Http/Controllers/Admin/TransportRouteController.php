<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransportRoute;
use App\Http\Requests\TransportRouteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * TransportRoute controller.
 *
 * Replaces CI3 controllers/admin/TransportRouteController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.transport-route' prefix.
 */
class TransportRouteController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.transport-route.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.transport-route.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.transport-route.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.transport-route.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = TransportRoute::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.transport-route.index', compact('records'));
    }

    public function create()
    {
        return view('admin.transport-route.create');
    }

    public function store(TransportRouteRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = TransportRoute::create($data);
            DB::commit();
            return redirect()->route('admin.transport-route.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(TransportRoute $record)
    {
        return view('admin.transport-route.show', compact('record'));
    }

    public function edit(TransportRoute $record)
    {
        return view('admin.transport-route.edit', compact('record'));
    }

    public function update(TransportRouteRequest $request, TransportRoute $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.transport-route.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(TransportRoute $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.transport-route.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
