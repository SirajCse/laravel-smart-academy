<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hostel;
use App\Http\Requests\HostelRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Hostel controller.
 *
 * Replaces CI3 controllers/admin/HostelController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.hostel' prefix.
 */
class HostelController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.hostel.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.hostel.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.hostel.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.hostel.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Hostel::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.hostel.index', compact('records'));
    }

    public function create()
    {
        return view('admin.hostel.create');
    }

    public function store(HostelRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Hostel::create($data);
            DB::commit();
            return redirect()->route('admin.hostel.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Hostel $record)
    {
        return view('admin.hostel.show', compact('record'));
    }

    public function edit(Hostel $record)
    {
        return view('admin.hostel.edit', compact('record'));
    }

    public function update(HostelRequest $request, Hostel $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.hostel.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Hostel $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.hostel.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
