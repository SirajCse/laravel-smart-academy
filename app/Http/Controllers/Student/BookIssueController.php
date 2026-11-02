<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\BookIssue;
use Illuminate\Http\Request;

class BookIssueController extends Controller
{
    public function index()
    {
        $user = auth('student')->user();
        $records = BookIssue::query();

        // Student-specific scoping
        if (method_exists(BookIssue::class, 'student')) {
            $records->where('user_id', $user->user_id);
        }

        $records = $records->latest()->paginate(15);
        return view('student.book-issue', compact('records'));
    }

    public function create()
    {
        return view('student.book-issue.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = auth('student')->user();
        if (isset($user->user_id)) {
            $data['user_id'] = $user->user_id;
        }
        BookIssue::create($data);
        return redirect()->route('student.book-issue.index')->with('success', __('Created.'));
    }

    public function show(BookIssue $record)
    {
        return view('student.book-issue.show', compact('record'));
    }

    public function edit(BookIssue $record)
    {
        return view('student.book-issue.edit', compact('record'));
    }

    public function update(Request $request, BookIssue $record)
    {
        $record->update($request->all());
        return redirect()->route('student.book-issue.index')->with('success', __('Updated.'));
    }

    public function destroy(BookIssue $record)
    {
        $record->delete();
        return redirect()->route('student.book-issue.index')->with('success', __('Deleted.'));
    }
}
