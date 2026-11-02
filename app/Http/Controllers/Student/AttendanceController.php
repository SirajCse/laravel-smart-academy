<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentAttendence;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = auth('student')->user();
        $records = StudentAttendence::query();

        // Student-specific scoping
        if (method_exists(StudentAttendence::class, 'student')) {
            $records->where('user_id', $user->user_id);
        }

        $records = $records->latest()->paginate(15);
        return view('student.attendance', compact('records'));
    }

    public function create()
    {
        return view('student.attendance.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = auth('student')->user();
        if (isset($user->user_id)) {
            $data['user_id'] = $user->user_id;
        }
        StudentAttendence::create($data);
        return redirect()->route('student.attendance.index')->with('success', __('Created.'));
    }

    public function show(StudentAttendence $record)
    {
        return view('student.attendance.show', compact('record'));
    }

    public function edit(StudentAttendence $record)
    {
        return view('student.attendance.edit', compact('record'));
    }

    public function update(Request $request, StudentAttendence $record)
    {
        $record->update($request->all());
        return redirect()->route('student.attendance.index')->with('success', __('Updated.'));
    }

    public function destroy(StudentAttendence $record)
    {
        $record->delete();
        return redirect()->route('student.attendance.index')->with('success', __('Deleted.'));
    }
}
