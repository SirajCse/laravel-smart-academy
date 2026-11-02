<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GenerateIdCard;
use App\Http\Requests\GenerateIdCardRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * GenerateIdCard controller.
 *
 * Replaces CI3 controllers/admin/GenerateidcardController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.generate-idcard' prefix.
 */
class GenerateidcardController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.generate-idcard.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.generate-idcard.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.generate-idcard.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.generate-idcard.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = GenerateIdCard::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.generate-idcard.index', compact('records'));
    }

    public function create()
    {
        return view('admin.generate-idcard.create');
    }

    public function store(GenerateIdCardRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = GenerateIdCard::create($data);
            DB::commit();
            return redirect()->route('admin.generate-idcard.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(GenerateIdCard $record)
    {
        return view('admin.generate-idcard.show', compact('record'));
    }

    public function edit(GenerateIdCard $record)
    {
        return view('admin.generate-idcard.edit', compact('record'));
    }

    public function update(GenerateIdCardRequest $request, GenerateIdCard $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.generate-idcard.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(GenerateIdCard $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.generate-idcard.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
