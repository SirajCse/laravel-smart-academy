<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Homework;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    public function index()
    {
        $user = auth('student')->user();
        $records = Homework::query();

        // Student-specific scoping
        if (method_exists(Homework::class, 'student')) {
            $records->where('user_id', $user->user_id);
        }

        $records = $records->latest()->paginate(15);
        return view('student.homework', compact('records'));
    }

    public function create()
    {
        return view('student.homework.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = auth('student')->user();
        if (isset($user->user_id)) {
            $data['user_id'] = $user->user_id;
        }
        Homework::create($data);
        return redirect()->route('student.homework.index')->with('success', __('Created.'));
    }

    public function show(Homework $record)
    {
        return view('student.homework.show', compact('record'));
    }

    public function edit(Homework $record)
    {
        return view('student.homework.edit', compact('record'));
    }

    public function update(Request $request, Homework $record)
    {
        $record->update($request->all());
        return redirect()->route('student.homework.index')->with('success', __('Updated.'));
    }

    public function destroy(Homework $record)
    {
        $record->delete();
        return redirect()->route('student.homework.index')->with('success', __('Deleted.'));
    }
}
