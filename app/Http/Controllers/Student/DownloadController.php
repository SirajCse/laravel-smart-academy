<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function index()
    {
        $user = auth('student')->user();
        $records = Document::query();

        // Student-specific scoping
        if (method_exists(Document::class, 'student')) {
            $records->where('user_id', $user->user_id);
        }

        $records = $records->latest()->paginate(15);
        return view('student.download', compact('records'));
    }

    public function create()
    {
        return view('student.download.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = auth('student')->user();
        if (isset($user->user_id)) {
            $data['user_id'] = $user->user_id;
        }
        Document::create($data);
        return redirect()->route('student.download.index')->with('success', __('Created.'));
    }

    public function show(Document $record)
    {
        return view('student.download.show', compact('record'));
    }

    public function edit(Document $record)
    {
        return view('student.download.edit', compact('record'));
    }

    public function update(Request $request, Document $record)
    {
        $record->update($request->all());
        return redirect()->route('student.download.index')->with('success', __('Updated.'));
    }

    public function destroy(Document $record)
    {
        $record->delete();
        return redirect()->route('student.download.index')->with('success', __('Deleted.'));
    }
}
