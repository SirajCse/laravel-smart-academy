<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeType;
use App\Http\Requests\FeeTypeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * FeeType controller.
 *
 * Replaces CI3 controllers/admin/FeetypeController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.feetype' prefix.
 */
class FeetypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.feetype.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.feetype.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.feetype.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.feetype.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = FeeType::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.feetype.index', compact('records'));
    }

    public function create()
    {
        return view('admin.feetype.create');
    }

    public function store(FeeTypeRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = FeeType::create($data);
            DB::commit();
            return redirect()->route('admin.feetype.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(FeeType $record)
    {
        return view('admin.feetype.show', compact('record'));
    }

    public function edit(FeeType $record)
    {
        return view('admin.feetype.edit', compact('record'));
    }

    public function update(FeeTypeRequest $request, FeeType $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.feetype.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(FeeType $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.feetype.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
