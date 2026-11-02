<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\TransportMember;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function index()
    {
        $user = auth('student')->user();
        $records = TransportMember::query();

        // Student-specific scoping
        if (method_exists(TransportMember::class, 'student')) {
            $records->where('user_id', $user->user_id);
        }

        $records = $records->latest()->paginate(15);
        return view('student.transport', compact('records'));
    }

    public function create()
    {
        return view('student.transport.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = auth('student')->user();
        if (isset($user->user_id)) {
            $data['user_id'] = $user->user_id;
        }
        TransportMember::create($data);
        return redirect()->route('student.transport.index')->with('success', __('Created.'));
    }

    public function show(TransportMember $record)
    {
        return view('student.transport.show', compact('record'));
    }

    public function edit(TransportMember $record)
    {
        return view('student.transport.edit', compact('record'));
    }

    public function update(Request $request, TransportMember $record)
    {
        $record->update($request->all());
        return redirect()->route('student.transport.index')->with('success', __('Updated.'));
    }

    public function destroy(TransportMember $record)
    {
        $record->delete();
        return redirect()->route('student.transport.index')->with('success', __('Deleted.'));
    }
}
