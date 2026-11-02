<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $user = auth('student')->user();
        $records = Book::query();

        // Student-specific scoping
        if (method_exists(Book::class, 'student')) {
            $records->where('user_id', $user->user_id);
        }

        $records = $records->latest()->paginate(15);
        return view('student.book', compact('records'));
    }

    public function create()
    {
        return view('student.book.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = auth('student')->user();
        if (isset($user->user_id)) {
            $data['user_id'] = $user->user_id;
        }
        Book::create($data);
        return redirect()->route('student.book.index')->with('success', __('Created.'));
    }

    public function show(Book $record)
    {
        return view('student.book.show', compact('record'));
    }

    public function edit(Book $record)
    {
        return view('student.book.edit', compact('record'));
    }

    public function update(Request $request, Book $record)
    {
        $record->update($request->all());
        return redirect()->route('student.book.index')->with('success', __('Updated.'));
    }

    public function destroy(Book $record)
    {
        $record->delete();
        return redirect()->route('student.book.index')->with('success', __('Deleted.'));
    }
}
