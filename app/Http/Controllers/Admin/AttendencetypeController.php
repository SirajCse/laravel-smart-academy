<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendenceType;
use App\Http\Requests\AttendenceTypeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * AttendenceType controller.
 *
 * Replaces CI3 controllers/admin/AttendencetypeController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.attendence-type' prefix.
 */
class AttendencetypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.attendence-type.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.attendence-type.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.attendence-type.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.attendence-type.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = AttendenceType::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.attendence-type.index', compact('records'));
    }

    public function create()
    {
        return view('admin.attendence-type.create');
    }

    public function store(AttendenceTypeRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = AttendenceType::create($data);
            DB::commit();
            return redirect()->route('admin.attendence-type.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(AttendenceType $record)
    {
        return view('admin.attendence-type.show', compact('record'));
    }

    public function edit(AttendenceType $record)
    {
        return view('admin.attendence-type.edit', compact('record'));
    }

    public function update(AttendenceTypeRequest $request, AttendenceType $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.attendence-type.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(AttendenceType $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.attendence-type.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
