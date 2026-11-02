<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $user = auth('student')->user();
        $records = Exam::query();

        // Student-specific scoping
        if (method_exists(Exam::class, 'student')) {
            $records->where('user_id', $user->user_id);
        }

        $records = $records->latest()->paginate(15);
        return view('student.exam', compact('records'));
    }

    public function create()
    {
        return view('student.exam.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = auth('student')->user();
        if (isset($user->user_id)) {
            $data['user_id'] = $user->user_id;
        }
        Exam::create($data);
        return redirect()->route('student.exam.index')->with('success', __('Created.'));
    }

    public function show(Exam $record)
    {
        return view('student.exam.show', compact('record'));
    }

    public function edit(Exam $record)
    {
        return view('student.exam.edit', compact('record'));
    }

    public function update(Request $request, Exam $record)
    {
        $record->update($request->all());
        return redirect()->route('student.exam.index')->with('success', __('Updated.'));
    }

    public function destroy(Exam $record)
    {
        $record->delete();
        return redirect()->route('student.exam.index')->with('success', __('Deleted.'));
    }
}
