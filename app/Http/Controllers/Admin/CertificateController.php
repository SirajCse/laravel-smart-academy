<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Http\Requests\CertificateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Certificate controller.
 *
 * Replaces CI3 controllers/admin/CertificateController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.certificate' prefix.
 */
class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.certificate.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.certificate.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.certificate.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.certificate.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Certificate::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.certificate.index', compact('records'));
    }

    public function create()
    {
        return view('admin.certificate.create');
    }

    public function store(CertificateRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Certificate::create($data);
            DB::commit();
            return redirect()->route('admin.certificate.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Certificate $record)
    {
        return view('admin.certificate.show', compact('record'));
    }

    public function edit(Certificate $record)
    {
        return view('admin.certificate.edit', compact('record'));
    }

    public function update(CertificateRequest $request, Certificate $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.certificate.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Certificate $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.certificate.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
