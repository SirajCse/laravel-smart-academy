<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        $user = auth('student')->user();
        $records = Timetable::query();

        // Student-specific scoping
        if (method_exists(Timetable::class, 'student')) {
            $records->where('user_id', $user->user_id);
        }

        $records = $records->latest()->paginate(15);
        return view('student.timetable', compact('records'));
    }

    public function create()
    {
        return view('student.timetable.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = auth('student')->user();
        if (isset($user->user_id)) {
            $data['user_id'] = $user->user_id;
        }
        Timetable::create($data);
        return redirect()->route('student.timetable.index')->with('success', __('Created.'));
    }

    public function show(Timetable $record)
    {
        return view('student.timetable.show', compact('record'));
    }

    public function edit(Timetable $record)
    {
        return view('student.timetable.edit', compact('record'));
    }

    public function update(Request $request, Timetable $record)
    {
        $record->update($request->all());
        return redirect()->route('student.timetable.index')->with('success', __('Updated.'));
    }

    public function destroy(Timetable $record)
    {
        $record->delete();
        return redirect()->route('student.timetable.index')->with('success', __('Deleted.'));
    }
}
