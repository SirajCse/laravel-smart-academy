<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentFeesDiscount;
use App\Http\Requests\StudentFeesDiscountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * StudentFeesDiscount controller.
 *
 * Replaces CI3 controllers/admin/StudentFeesDiscountController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.student-fees-discount' prefix.
 */
class StudentFeesDiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.student-fees-discount.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.student-fees-discount.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.student-fees-discount.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.student-fees-discount.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = StudentFeesDiscount::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.student-fees-discount.index', compact('records'));
    }

    public function create()
    {
        return view('admin.student-fees-discount.create');
    }

    public function store(StudentFeesDiscountRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = StudentFeesDiscount::create($data);
            DB::commit();
            return redirect()->route('admin.student-fees-discount.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(StudentFeesDiscount $record)
    {
        return view('admin.student-fees-discount.show', compact('record'));
    }

    public function edit(StudentFeesDiscount $record)
    {
        return view('admin.student-fees-discount.edit', compact('record'));
    }

    public function update(StudentFeesDiscountRequest $request, StudentFeesDiscount $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.student-fees-discount.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(StudentFeesDiscount $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.student-fees-discount.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
