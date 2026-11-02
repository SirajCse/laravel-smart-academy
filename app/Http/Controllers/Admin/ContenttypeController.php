<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contenttype;
use App\Http\Requests\ContenttypeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Contenttype controller.
 *
 * Replaces CI3 controllers/admin/ContenttypeController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.content-type' prefix.
 */
class ContenttypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.content-type.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.content-type.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.content-type.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.content-type.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Contenttype::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.content-type.index', compact('records'));
    }

    public function create()
    {
        return view('admin.content-type.create');
    }

    public function store(ContenttypeRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Contenttype::create($data);
            DB::commit();
            return redirect()->route('admin.content-type.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Contenttype $record)
    {
        return view('admin.content-type.show', compact('record'));
    }

    public function edit(Contenttype $record)
    {
        return view('admin.content-type.edit', compact('record'));
    }

    public function update(ContenttypeRequest $request, Contenttype $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.content-type.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Contenttype $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.content-type.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
