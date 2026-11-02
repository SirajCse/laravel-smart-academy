<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FrontcmsSetting;
use App\Http\Requests\FrontcmsSettingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * FrontcmsSetting controller.
 *
 * Replaces CI3 controllers/admin/FrontcmsSettingController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.frontcms-setting' prefix.
 */
class FrontcmsSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.frontcms-setting.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.frontcms-setting.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.frontcms-setting.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.frontcms-setting.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = FrontcmsSetting::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.frontcms-setting.index', compact('records'));
    }

    public function create()
    {
        return view('admin.frontcms-setting.create');
    }

    public function store(FrontcmsSettingRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = FrontcmsSetting::create($data);
            DB::commit();
            return redirect()->route('admin.frontcms-setting.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(FrontcmsSetting $record)
    {
        return view('admin.frontcms-setting.show', compact('record'));
    }

    public function edit(FrontcmsSetting $record)
    {
        return view('admin.frontcms-setting.edit', compact('record'));
    }

    public function update(FrontcmsSettingRequest $request, FrontcmsSetting $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.frontcms-setting.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(FrontcmsSetting $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.frontcms-setting.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
