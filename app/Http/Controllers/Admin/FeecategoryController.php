<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeCategory;
use App\Http\Requests\FeeCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * FeeCategory controller.
 *
 * Replaces CI3 controllers/admin/FeecategoryController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.feecategory' prefix.
 */
class FeecategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.feecategory.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.feecategory.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.feecategory.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.feecategory.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = FeeCategory::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.feecategory.index', compact('records'));
    }

    public function create()
    {
        return view('admin.feecategory.create');
    }

    public function store(FeeCategoryRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = FeeCategory::create($data);
            DB::commit();
            return redirect()->route('admin.feecategory.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(FeeCategory $record)
    {
        return view('admin.feecategory.show', compact('record'));
    }

    public function edit(FeeCategory $record)
    {
        return view('admin.feecategory.edit', compact('record'));
    }

    public function update(FeeCategoryRequest $request, FeeCategory $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.feecategory.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(FeeCategory $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.feecategory.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
