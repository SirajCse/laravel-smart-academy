<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralCall;
use App\Http\Requests\GeneralCallRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * GeneralCall controller.
 *
 * Replaces CI3 controllers/admin/GeneralCallController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.general-call' prefix.
 */
class GeneralCallController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.general-call.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.general-call.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.general-call.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.general-call.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = GeneralCall::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.general-call.index', compact('records'));
    }

    public function create()
    {
        return view('admin.general-call.create');
    }

    public function store(GeneralCallRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = GeneralCall::create($data);
            DB::commit();
            return redirect()->route('admin.general-call.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(GeneralCall $record)
    {
        return view('admin.general-call.show', compact('record'));
    }

    public function edit(GeneralCall $record)
    {
        return view('admin.general-call.edit', compact('record'));
    }

    public function update(GeneralCallRequest $request, GeneralCall $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.general-call.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(GeneralCall $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.general-call.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
