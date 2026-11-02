<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseHead;
use App\Http\Requests\ExpenseHeadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ExpenseHead controller.
 *
 * Replaces CI3 controllers/admin/ExpenseheadController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.expense-head' prefix.
 */
class ExpenseheadController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.expense-head.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.expense-head.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.expense-head.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.expense-head.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = ExpenseHead::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.expense-head.index', compact('records'));
    }

    public function create()
    {
        return view('admin.expense-head.create');
    }

    public function store(ExpenseHeadRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = ExpenseHead::create($data);
            DB::commit();
            return redirect()->route('admin.expense-head.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(ExpenseHead $record)
    {
        return view('admin.expense-head.show', compact('record'));
    }

    public function edit(ExpenseHead $record)
    {
        return view('admin.expense-head.edit', compact('record'));
    }

    public function update(ExpenseHeadRequest $request, ExpenseHead $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.expense-head.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(ExpenseHead $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.expense-head.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
