<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeReminder;
use App\Http\Requests\FeeReminderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * FeeReminder controller.
 *
 * Replaces CI3 controllers/admin/FeereminderController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.feereminder' prefix.
 */
class FeereminderController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.feereminder.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.feereminder.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.feereminder.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.feereminder.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = FeeReminder::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.feereminder.index', compact('records'));
    }

    public function create()
    {
        return view('admin.feereminder.create');
    }

    public function store(FeeReminderRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = FeeReminder::create($data);
            DB::commit();
            return redirect()->route('admin.feereminder.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(FeeReminder $record)
    {
        return view('admin.feereminder.show', compact('record'));
    }

    public function edit(FeeReminder $record)
    {
        return view('admin.feereminder.edit', compact('record'));
    }

    public function update(FeeReminderRequest $request, FeeReminder $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.feereminder.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(FeeReminder $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.feereminder.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
