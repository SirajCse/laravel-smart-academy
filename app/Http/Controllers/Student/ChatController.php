<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ChatUser;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $user = auth('student')->user();
        $records = ChatUser::query();

        // Student-specific scoping
        if (method_exists(ChatUser::class, 'student')) {
            $records->where('user_id', $user->user_id);
        }

        $records = $records->latest()->paginate(15);
        return view('student.chat', compact('records'));
    }

    public function create()
    {
        return view('student.chat.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = auth('student')->user();
        if (isset($user->user_id)) {
            $data['user_id'] = $user->user_id;
        }
        ChatUser::create($data);
        return redirect()->route('student.chat.index')->with('success', __('Created.'));
    }

    public function show(ChatUser $record)
    {
        return view('student.chat.show', compact('record'));
    }

    public function edit(ChatUser $record)
    {
        return view('student.chat.edit', compact('record'));
    }

    public function update(Request $request, ChatUser $record)
    {
        $record->update($request->all());
        return redirect()->route('student.chat.index')->with('success', __('Updated.'));
    }

    public function destroy(ChatUser $record)
    {
        $record->delete();
        return redirect()->route('student.chat.index')->with('success', __('Deleted.'));
    }
}
