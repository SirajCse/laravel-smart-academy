<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FrontcmsMedia;
use App\Http\Requests\FrontcmsMediaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * FrontcmsMedia controller.
 *
 * Replaces CI3 controllers/admin/FrontcmsMediaController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.frontcms-media' prefix.
 */
class FrontcmsMediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.frontcms-media.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.frontcms-media.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.frontcms-media.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.frontcms-media.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = FrontcmsMedia::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.frontcms-media.index', compact('records'));
    }

    public function create()
    {
        return view('admin.frontcms-media.create');
    }

    public function store(FrontcmsMediaRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = FrontcmsMedia::create($data);
            DB::commit();
            return redirect()->route('admin.frontcms-media.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(FrontcmsMedia $record)
    {
        return view('admin.frontcms-media.show', compact('record'));
    }

    public function edit(FrontcmsMedia $record)
    {
        return view('admin.frontcms-media.edit', compact('record'));
    }

    public function update(FrontcmsMediaRequest $request, FrontcmsMedia $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.frontcms-media.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(FrontcmsMedia $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.frontcms-media.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
