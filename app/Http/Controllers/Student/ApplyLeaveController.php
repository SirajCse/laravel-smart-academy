<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ApplyLeave;
use Illuminate\Http\Request;

class ApplyLeaveController extends Controller
{
    public function index()
    {
        $user = auth('student')->user();
        $records = ApplyLeave::query();

        // Student-specific scoping
        if (method_exists(ApplyLeave::class, 'student')) {
            $records->where('user_id', $user->user_id);
        }

        $records = $records->latest()->paginate(15);
        return view('student.apply-leave', compact('records'));
    }

    public function create()
    {
        return view('student.apply-leave.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = auth('student')->user();
        if (isset($user->user_id)) {
            $data['user_id'] = $user->user_id;
        }
        ApplyLeave::create($data);
        return redirect()->route('student.apply-leave.index')->with('success', __('Created.'));
    }

    public function show(ApplyLeave $record)
    {
        return view('student.apply-leave.show', compact('record'));
    }

    public function edit(ApplyLeave $record)
    {
        return view('student.apply-leave.edit', compact('record'));
    }

    public function update(Request $request, ApplyLeave $record)
    {
        $record->update($request->all());
        return redirect()->route('student.apply-leave.index')->with('success', __('Updated.'));
    }

    public function destroy(ApplyLeave $record)
    {
        $record->delete();
        return redirect()->route('student.apply-leave.index')->with('success', __('Deleted.'));
    }
}
