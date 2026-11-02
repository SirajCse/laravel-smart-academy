<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Category controller.
 *
 * Replaces CI3 controllers/admin/CategoryController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.category' prefix.
 */
class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.category.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.category.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.category.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.category.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Category::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.category.index', compact('records'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Category::create($data);
            DB::commit();
            return redirect()->route('admin.category.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Category $record)
    {
        return view('admin.category.show', compact('record'));
    }

    public function edit(Category $record)
    {
        return view('admin.category.edit', compact('record'));
    }

    public function update(CategoryRequest $request, Category $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.category.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Category $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.category.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
