<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Http\Requests\EnquiryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Enquiry controller.
 *
 * Replaces CI3 controllers/admin/EnquiryController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.enquiry' prefix.
 */
class EnquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.enquiry.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.enquiry.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.enquiry.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.enquiry.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Enquiry::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.enquiry.index', compact('records'));
    }

    public function create()
    {
        return view('admin.enquiry.create');
    }

    public function store(EnquiryRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Enquiry::create($data);
            DB::commit();
            return redirect()->route('admin.enquiry.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Enquiry $record)
    {
        return view('admin.enquiry.show', compact('record'));
    }

    public function edit(Enquiry $record)
    {
        return view('admin.enquiry.edit', compact('record'));
    }

    public function update(EnquiryRequest $request, Enquiry $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.enquiry.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Enquiry $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.enquiry.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
