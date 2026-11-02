<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use App\Http\Requests\HolidayRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Holiday controller.
 *
 * Replaces CI3 controllers/admin/HolidayController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.holiday' prefix.
 */
class HolidayController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.holiday.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.holiday.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.holiday.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.holiday.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Holiday::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.holiday.index', compact('records'));
    }

    public function create()
    {
        return view('admin.holiday.create');
    }

    public function store(HolidayRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Holiday::create($data);
            DB::commit();
            return redirect()->route('admin.holiday.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Holiday $record)
    {
        return view('admin.holiday.show', compact('record'));
    }

    public function edit(Holiday $record)
    {
        return view('admin.holiday.edit', compact('record'));
    }

    public function update(HolidayRequest $request, Holiday $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.holiday.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Holiday $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.holiday.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
