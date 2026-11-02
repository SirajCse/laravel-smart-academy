<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentFeesMaster;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        $user = auth('student')->user();
        $records = StudentFeesMaster::query();

        // Student-specific scoping
        if (method_exists(StudentFeesMaster::class, 'student')) {
            $records->where('user_id', $user->user_id);
        }

        $records = $records->latest()->paginate(15);
        return view('student.fees', compact('records'));
    }

    public function create()
    {
        return view('student.fees.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = auth('student')->user();
        if (isset($user->user_id)) {
            $data['user_id'] = $user->user_id;
        }
        StudentFeesMaster::create($data);
        return redirect()->route('student.fees.index')->with('success', __('Created.'));
    }

    public function show(StudentFeesMaster $record)
    {
        return view('student.fees.show', compact('record'));
    }

    public function edit(StudentFeesMaster $record)
    {
        return view('student.fees.edit', compact('record'));
    }

    public function update(Request $request, StudentFeesMaster $record)
    {
        $record->update($request->all());
        return redirect()->route('student.fees.index')->with('success', __('Updated.'));
    }

    public function destroy(StudentFeesMaster $record)
    {
        $record->delete();
        return redirect()->route('student.fees.index')->with('success', __('Deleted.'));
    }
}
