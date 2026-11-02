<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LibraryMember;
use App\Http\Requests\LibraryMemberRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * LibraryMember controller.
 *
 * Replaces CI3 controllers/admin/LibraryMemberController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.library-member' prefix.
 */
class LibraryMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.library-member.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.library-member.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.library-member.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.library-member.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = LibraryMember::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.library-member.index', compact('records'));
    }

    public function create()
    {
        return view('admin.library-member.create');
    }

    public function store(LibraryMemberRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = LibraryMember::create($data);
            DB::commit();
            return redirect()->route('admin.library-member.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(LibraryMember $record)
    {
        return view('admin.library-member.show', compact('record'));
    }

    public function edit(LibraryMember $record)
    {
        return view('admin.library-member.edit', compact('record'));
    }

    public function update(LibraryMemberRequest $request, LibraryMember $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.library-member.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(LibraryMember $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.library-member.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
