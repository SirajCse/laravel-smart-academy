<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\HostelMember;
use Illuminate\Http\Request;

class HostelController extends Controller
{
    public function index()
    {
        $user = auth('student')->user();
        $records = HostelMember::query();

        // Student-specific scoping
        if (method_exists(HostelMember::class, 'student')) {
            $records->where('user_id', $user->user_id);
        }

        $records = $records->latest()->paginate(15);
        return view('student.hostel', compact('records'));
    }

    public function create()
    {
        return view('student.hostel.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = auth('student')->user();
        if (isset($user->user_id)) {
            $data['user_id'] = $user->user_id;
        }
        HostelMember::create($data);
        return redirect()->route('student.hostel.index')->with('success', __('Created.'));
    }

    public function show(HostelMember $record)
    {
        return view('student.hostel.show', compact('record'));
    }

    public function edit(HostelMember $record)
    {
        return view('student.hostel.edit', compact('record'));
    }

    public function update(Request $request, HostelMember $record)
    {
        $record->update($request->all());
        return redirect()->route('student.hostel.index')->with('success', __('Updated.'));
    }

    public function destroy(HostelMember $record)
    {
        $record->delete();
        return redirect()->route('student.hostel.index')->with('success', __('Deleted.'));
    }
}
