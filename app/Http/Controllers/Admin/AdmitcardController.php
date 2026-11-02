<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmitCard;
use App\Http\Requests\AdmitCardRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * AdmitCard controller.
 *
 * Replaces CI3 controllers/admin/AdmitcardController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.admitcard' prefix.
 */
class AdmitcardController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.admitcard.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.admitcard.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.admitcard.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.admitcard.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = AdmitCard::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.admitcard.index', compact('records'));
    }

    public function create()
    {
        return view('admin.admitcard.create');
    }

    public function store(AdmitCardRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = AdmitCard::create($data);
            DB::commit();
            return redirect()->route('admin.admitcard.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(AdmitCard $record)
    {
        return view('admin.admitcard.show', compact('record'));
    }

    public function edit(AdmitCard $record)
    {
        return view('admin.admitcard.edit', compact('record'));
    }

    public function update(AdmitCardRequest $request, AdmitCard $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.admitcard.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(AdmitCard $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.admitcard.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
