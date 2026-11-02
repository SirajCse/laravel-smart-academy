<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookIssue;
use App\Http\Requests\BookIssueRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * BookIssue controller.
 *
 * Replaces CI3 controllers/admin/BookissueController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.book-issue' prefix.
 */
class BookissueController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.book-issue.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.book-issue.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.book-issue.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.book-issue.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = BookIssue::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.book-issue.index', compact('records'));
    }

    public function create()
    {
        return view('admin.book-issue.create');
    }

    public function store(BookIssueRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = BookIssue::create($data);
            DB::commit();
            return redirect()->route('admin.book-issue.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(BookIssue $record)
    {
        return view('admin.book-issue.show', compact('record'));
    }

    public function edit(BookIssue $record)
    {
        return view('admin.book-issue.edit', compact('record'));
    }

    public function update(BookIssueRequest $request, BookIssue $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.book-issue.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(BookIssue $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.book-issue.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
