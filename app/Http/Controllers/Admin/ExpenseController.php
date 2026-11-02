<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Http\Requests\ExpenseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Expense controller.
 *
 * Replaces CI3 controllers/admin/ExpenseController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.expense' prefix.
 */
class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.expense.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.expense.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.expense.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.expense.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Expense::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.expense.index', compact('records'));
    }

    public function create()
    {
        return view('admin.expense.create');
    }

    public function store(ExpenseRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Expense::create($data);
            DB::commit();
            return redirect()->route('admin.expense.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Expense $record)
    {
        return view('admin.expense.show', compact('record'));
    }

    public function edit(Expense $record)
    {
        return view('admin.expense.edit', compact('record'));
    }

    public function update(ExpenseRequest $request, Expense $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.expense.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Expense $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.expense.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
