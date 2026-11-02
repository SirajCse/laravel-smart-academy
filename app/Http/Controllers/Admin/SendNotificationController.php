<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SendNotification;
use App\Http\Requests\SendNotificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * SendNotification controller.
 *
 * Replaces CI3 controllers/admin/SendNotificationController.php
 * Resourceful routes are declared in routes/admin.php under the
 * 'admin.send-notification' prefix.
 */
class SendNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:admin.send-notification.view')->only(['index', 'show']);
        $this->middleware('rbac:admin.send-notification.create')->only(['create', 'store']);
        $this->middleware('rbac:admin.send-notification.edit')->only(['edit', 'update']);
        $this->middleware('rbac:admin.send-notification.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = SendNotification::query();

        if ($search = $request->get('search')) {
            $records->where(function ($q) use ($search) {
                $q->where('id', 'like', "%" . $search . "%");
            });
        }

        $records = $records->latest()->paginate(25);

        return view('admin.send-notification.index', compact('records'));
    }

    public function create()
    {
        return view('admin.send-notification.create');
    }

    public function store(SendNotificationRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record = SendNotification::create($data);
            DB::commit();
            return redirect()->route('admin.send-notification.index')
                ->with('success', __('Record created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create record.') . ' ' . $e->getMessage());
        }
    }

    public function show(SendNotification $record)
    {
        return view('admin.send-notification.show', compact('record'));
    }

    public function edit(SendNotification $record)
    {
        return view('admin.send-notification.edit', compact('record'));
    }

    public function update(SendNotificationRequest $request, SendNotification $record)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $record->update($data);
            DB::commit();
            return redirect()->route('admin.send-notification.index')
                ->with('success', __('Record updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update record.') . ' ' . $e->getMessage());
        }
    }

    public function destroy(SendNotification $record)
    {
        try {
            $record->delete();
            return redirect()->route('admin.send-notification.index')
                ->with('success', __('Record deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete record.'));
        }
    }
}
