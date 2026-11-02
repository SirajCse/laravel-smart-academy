<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Homework, HomeworkEvaluation};
use App\Services\MediaStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeworkController extends Controller
{
    public function __construct(private MediaStorageService $media)
    {
        $this->middleware('rbac:homework.view')->only(['index', 'show']);
        $this->middleware('rbac:homework.create')->only(['create', 'store']);
        $this->middleware('rbac:homework.edit')->only(['edit', 'update', 'saveEvaluation']);
        $this->middleware('rbac:homework.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $query = Homework::with(['class', 'section', 'subject', 'staff']);
        if ($classId = $request->get('class_id')) {
            $query->where('class_id', $classId);
        }
        $records = $query->latest()->paginate(25);
        return view('admin.homework.index', compact('records'));
    }

    public function create()
    {
        return view('admin.homework.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'class_id' => 'required|integer',
            'section_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'staff_id' => 'nullable|integer',
            'homework_date' => 'required|date',
            'submit_date' => 'required|date|after_or_equal:homework_date',
            'marks' => 'nullable|numeric',
            'description' => 'required|string',
            'document' => 'nullable|file|max:10240',
            'session_id' => 'required|integer',
        ]);
        if ($request->hasFile('document')) {
            $data['document'] = $this->media->upload($request->file('document'), 'homework', 'HW');
        }
        $homework = Homework::create($data);
        event(new \App\Events\HomeworkAssigned($homework));
        return redirect()->route('admin.homework.index')->with('success', __('Homework assigned successfully.'));
    }

    public function show(Homework $homework)
    {
        $record = $homework;
        $record->load(['evaluations.studentSession.student']);
        return view('admin.homework.show', compact('record'));
    }

    public function edit(Homework $homework)
    {
        $record = $homework;
        return view('admin.homework.edit', compact('record'));
    }

    public function update(Request $request, Homework $homework)
    {
        $data = $request->validate([
            'class_id' => 'required|integer',
            'section_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'staff_id' => 'nullable|integer',
            'homework_date' => 'required|date',
            'submit_date' => 'required|date',
            'marks' => 'nullable|numeric',
            'description' => 'required|string',
            'document' => 'nullable|file|max:10240',
        ]);
        if ($request->hasFile('document')) {
            if ($homework->document) $this->media->delete($homework->document);
            $data['document'] = $this->media->upload($request->file('document'), 'homework', 'HW');
        }
        $homework->update($data);
        return redirect()->route('admin.homework.index')->with('success', __('Homework updated.'));
    }

    public function destroy(Homework $homework)
    {
        if ($homework->document) $this->media->delete($homework->document);
        $homework->delete();
        return redirect()->route('admin.homework.index')->with('success', __('Homework deleted.'));
    }

    public function saveEvaluation(Request $request, int $id)
    {
        $data = $request->validate([
            'student_session_id' => 'required|integer',
            'evaluation' => 'nullable|string',
            'marks' => 'nullable|numeric',
            'remark' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
        ]);
        $data['homework_id'] = $id;
        if ($request->hasFile('file')) {
            $data['file'] = $this->media->upload($request->file('file'), 'homework', 'EVAL');
        }
        HomeworkEvaluation::updateOrCreate(
            ['homework_id' => $id, 'student_session_id' => $data['student_session_id']],
            $data
        );
        return back()->with('success', __('Evaluation saved.'));
    }
}
