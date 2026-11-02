<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filetype;
use App\Http\Requests\FiletypeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Filetype controller.
 *
 * Replaces CI3 controllers/admin/FiletypeController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.file-type' prefix.
 */
class FiletypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.file-type.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.file-type.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.file-type.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.file-type.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Filetype::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.file-type.index', compact('records'));
    }

    public function create()
    {
        return view('admin.file-type.create');
    }

    public function store(FiletypeRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Filetype::create($data);
            DB::commit();
            return redirect()->route('admin.file-type.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Filetype $record)
    {
        return view('admin.file-type.show', compact('record'));
    }

    public function edit(Filetype $record)
    {
        return view('admin.file-type.edit', compact('record'));
    }

    public function update(FiletypeRequest $request, Filetype $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.file-type.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Filetype $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.file-type.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
