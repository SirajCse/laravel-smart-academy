<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncomeHead;
use App\Http\Requests\IncomeHeadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * IncomeHead controller.
 *
 * Replaces CI3 controllers/admin/IncomeheadController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.income-head' prefix.
 */
class IncomeheadController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.income-head.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.income-head.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.income-head.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.income-head.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = IncomeHead::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.income-head.index', compact('records'));
    }

    public function create()
    {
        return view('admin.income-head.create');
    }

    public function store(IncomeHeadRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = IncomeHead::create($data);
            DB::commit();
            return redirect()->route('admin.income-head.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(IncomeHead $record)
    {
        return view('admin.income-head.show', compact('record'));
    }

    public function edit(IncomeHead $record)
    {
        return view('admin.income-head.edit', compact('record'));
    }

    public function update(IncomeHeadRequest $request, IncomeHead $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.income-head.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(IncomeHead $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.income-head.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
