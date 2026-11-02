<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth('student')->user();
        $records = Notification::query();

        // Student-specific scoping
        if (method_exists(Notification::class, 'student')) {
            $records->where('user_id', $user->user_id);
        }

        $records = $records->latest()->paginate(15);
        return view('student.notification', compact('records'));
    }

    public function create()
    {
        return view('student.notification.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = auth('student')->user();
        if (isset($user->user_id)) {
            $data['user_id'] = $user->user_id;
        }
        Notification::create($data);
        return redirect()->route('student.notification.index')->with('success', __('Created.'));
    }

    public function show(Notification $record)
    {
        return view('student.notification.show', compact('record'));
    }

    public function edit(Notification $record)
    {
        return view('student.notification.edit', compact('record'));
    }

    public function update(Request $request, Notification $record)
    {
        $record->update($request->all());
        return redirect()->route('student.notification.index')->with('success', __('Updated.'));
    }

    public function destroy(Notification $record)
    {
        $record->delete();
        return redirect()->route('student.notification.index')->with('success', __('Deleted.'));
    }
}
