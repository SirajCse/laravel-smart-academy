<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentFeesMaster;
use App\Http\Requests\StudentFeesMasterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * StudentFeesMaster controller.
 *
 * Replaces CI3 controllers/admin/StudentFeesMasterController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.student-fees-master' prefix.
 */
class StudentFeesMasterController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.student-fees-master.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.student-fees-master.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.student-fees-master.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.student-fees-master.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = StudentFeesMaster::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.student-fees-master.index', compact('records'));
    }

    public function create()
    {
        return view('admin.student-fees-master.create');
    }

    public function store(StudentFeesMasterRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = StudentFeesMaster::create($data);
            DB::commit();
            return redirect()->route('admin.student-fees-master.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(StudentFeesMaster $record)
    {
        return view('admin.student-fees-master.show', compact('record'));
    }

    public function edit(StudentFeesMaster $record)
    {
        return view('admin.student-fees-master.edit', compact('record'));
    }

    public function update(StudentFeesMasterRequest $request, StudentFeesMaster $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.student-fees-master.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(StudentFeesMaster $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.student-fees-master.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
