<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Http\Requests\AlumniRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Alumni controller.
 *
 * Replaces CI3 controllers/admin/AlumniController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.alumni' prefix.
 */
class AlumniController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.alumni.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.alumni.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.alumni.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.alumni.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Alumni::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.alumni.index', compact('records'));
    }

    public function create()
    {
        return view('admin.alumni.create');
    }

    public function store(AlumniRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Alumni::create($data);
            DB::commit();
            return redirect()->route('admin.alumni.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Alumni $record)
    {
        return view('admin.alumni.show', compact('record'));
    }

    public function edit(Alumni $record)
    {
        return view('admin.alumni.edit', compact('record'));
    }

    public function update(AlumniRequest $request, Alumni $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.alumni.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Alumni $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.alumni.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
