<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FrontcmsProgram;
use App\Http\Requests\FrontcmsProgramRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * FrontcmsProgram controller.
 *
 * Replaces CI3 controllers/admin/FrontcmsProgramController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.frontcms-program' prefix.
 */
class FrontcmsProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.frontcms-program.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.frontcms-program.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.frontcms-program.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.frontcms-program.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = FrontcmsProgram::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.frontcms-program.index', compact('records'));
    }

    public function create()
    {
        return view('admin.frontcms-program.create');
    }

    public function store(FrontcmsProgramRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = FrontcmsProgram::create($data);
            DB::commit();
            return redirect()->route('admin.frontcms-program.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(FrontcmsProgram $record)
    {
        return view('admin.frontcms-program.show', compact('record'));
    }

    public function edit(FrontcmsProgram $record)
    {
        return view('admin.frontcms-program.edit', compact('record'));
    }

    public function update(FrontcmsProgramRequest $request, FrontcmsProgram $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.frontcms-program.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(FrontcmsProgram $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.frontcms-program.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
