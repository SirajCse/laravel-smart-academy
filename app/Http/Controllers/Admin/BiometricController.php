<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Biometric;
use App\Http\Requests\BiometricRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Biometric controller.
 *
 * Replaces CI3 controllers/admin/BiometricController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.biometric' prefix.
 */
class BiometricController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.biometric.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.biometric.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.biometric.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.biometric.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Biometric::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.biometric.index', compact('records'));
    }

    public function create()
    {
        return view('admin.biometric.create');
    }

    public function store(BiometricRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Biometric::create($data);
            DB::commit();
            return redirect()->route('admin.biometric.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Biometric $record)
    {
        return view('admin.biometric.show', compact('record'));
    }

    public function edit(Biometric $record)
    {
        return view('admin.biometric.edit', compact('record'));
    }

    public function update(BiometricRequest $request, Biometric $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.biometric.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Biometric $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.biometric.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
