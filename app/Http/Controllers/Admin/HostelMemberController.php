<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HostelMember;
use App\Http\Requests\HostelMemberRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * HostelMember controller.
 *
 * Replaces CI3 controllers/admin/HostelMemberController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.hostel-member' prefix.
 */
class HostelMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.hostel-member.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.hostel-member.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.hostel-member.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.hostel-member.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = HostelMember::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.hostel-member.index', compact('records'));
    }

    public function create()
    {
        return view('admin.hostel-member.create');
    }

    public function store(HostelMemberRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = HostelMember::create($data);
            DB::commit();
            return redirect()->route('admin.hostel-member.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(HostelMember $record)
    {
        return view('admin.hostel-member.show', compact('record'));
    }

    public function edit(HostelMember $record)
    {
        return view('admin.hostel-member.edit', compact('record'));
    }

    public function update(HostelMemberRequest $request, HostelMember $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.hostel-member.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(HostelMember $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.hostel-member.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
