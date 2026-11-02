<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Http\Requests\ContentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Content controller.
 *
 * Replaces CI3 controllers/admin/ContentController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.content' prefix.
 */
class ContentController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.content.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.content.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.content.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.content.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Content::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.content.index', compact('records'));
    }

    public function create()
    {
        return view('admin.content.create');
    }

    public function store(ContentRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Content::create($data);
            DB::commit();
            return redirect()->route('admin.content.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Content $record)
    {
        return view('admin.content.show', compact('record'));
    }

    public function edit(Content $record)
    {
        return view('admin.content.edit', compact('record'));
    }

    public function update(ContentRequest $request, Content $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.content.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Content $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.content.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
