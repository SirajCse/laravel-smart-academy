<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    public function index()
    {
        $user = auth('student')->user();
        $records = User::query();

        // Student-specific scoping
        if (method_exists(User::class, 'student')) {
            $records->where('user_id', $user->user_id);
        }

        $records = $records->latest()->paginate(15);
        return view('student.change-password', compact('records'));
    }

    public function create()
    {
        return view('student.change-password.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = auth('student')->user();
        if (isset($user->user_id)) {
            $data['user_id'] = $user->user_id;
        }
        User::create($data);
        return redirect()->route('student.change_password.index')->with('success', __('Created.'));
    }

    public function show(User $record)
    {
        return view('student.change-password.show', compact('record'));
    }

    public function edit(User $record)
    {
        return view('student.change-password.edit', compact('record'));
    }

    public function update(Request $request, User $record)
    {
        $record->update($request->all());
        return redirect()->route('student.change_password.index')->with('success', __('Updated.'));
    }

    public function destroy(User $record)
    {
        $record->delete();
        return redirect()->route('student.change_password.index')->with('success', __('Deleted.'));
    }
}
