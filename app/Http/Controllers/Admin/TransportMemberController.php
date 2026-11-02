<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransportMember;
use App\Http\Requests\TransportMemberRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * TransportMember controller.
 *
 * Replaces CI3 controllers/admin/TransportMemberController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.transport-member' prefix.
 */
class TransportMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.transport-member.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.transport-member.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.transport-member.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.transport-member.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = TransportMember::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.transport-member.index', compact('records'));
    }

    public function create()
    {
        return view('admin.transport-member.create');
    }

    public function store(TransportMemberRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = TransportMember::create($data);
            DB::commit();
            return redirect()->route('admin.transport-member.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(TransportMember $record)
    {
        return view('admin.transport-member.show', compact('record'));
    }

    public function edit(TransportMember $record)
    {
        return view('admin.transport-member.edit', compact('record'));
    }

    public function update(TransportMemberRequest $request, TransportMember $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.transport-member.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(TransportMember $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.transport-member.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
