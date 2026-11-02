<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FrontcmsMenu;
use App\Http\Requests\FrontcmsMenuRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * FrontcmsMenu controller.
 *
 * Replaces CI3 controllers/admin/FrontcmsMenuController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.frontcms-menu' prefix.
 */
class FrontcmsMenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.frontcms-menu.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.frontcms-menu.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.frontcms-menu.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.frontcms-menu.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = FrontcmsMenu::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.frontcms-menu.index', compact('records'));
    }

    public function create()
    {
        return view('admin.frontcms-menu.create');
    }

    public function store(FrontcmsMenuRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = FrontcmsMenu::create($data);
            DB::commit();
            return redirect()->route('admin.frontcms-menu.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(FrontcmsMenu $record)
    {
        return view('admin.frontcms-menu.show', compact('record'));
    }

    public function edit(FrontcmsMenu $record)
    {
        return view('admin.frontcms-menu.edit', compact('record'));
    }

    public function update(FrontcmsMenuRequest $request, FrontcmsMenu $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.frontcms-menu.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(FrontcmsMenu $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.frontcms-menu.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
