<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Http\Requests\LanguageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Language controller.
 *
 * Replaces CI3 controllers/admin/LanguageController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.language' prefix.
 */
class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.language.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.language.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.language.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.language.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = Language::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.language.index', compact('records'));
    }

    public function create()
    {
        return view('admin.language.create');
    }

    public function store(LanguageRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = Language::create($data);
            DB::commit();
            return redirect()->route('admin.language.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(Language $record)
    {
        return view('admin.language.show', compact('record'));
    }

    public function edit(Language $record)
    {
        return view('admin.language.edit', compact('record'));
    }

    public function update(LanguageRequest $request, Language $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.language.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(Language $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.language.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
