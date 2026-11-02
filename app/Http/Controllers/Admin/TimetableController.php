<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use App\Http\Requests\TimetableRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Timetable controller.
 *
 * Replaces CI3 controllers/admin/TimetableController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.timetable' prefix.
 */
class TimetableController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.timetable.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.timetable.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.timetable.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.timetable.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Timetable::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.timetable.index', compact('records'));
    }

    public function create()
    {
        return view('admin.timetable.create');
    }

    public function store(TimetableRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Timetable::create($data);
            DB::commit();
            return redirect()->route('admin.timetable.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Timetable $record)
    {
        return view('admin.timetable.show', compact('record'));
    }

    public function edit(Timetable $record)
    {
        return view('admin.timetable.edit', compact('record'));
    }

    public function update(TimetableRequest $request, Timetable $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.timetable.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Timetable $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.timetable.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
