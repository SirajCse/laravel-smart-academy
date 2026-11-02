<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\ClassSection;
use Illuminate\Http\Request;

/**
 * Class controller — handles both `classes` and `sections` for a class.
 */
class ClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:class.view')->only(['index', 'show']);
        $this->middleware('rbac:class.create')->only(['create', 'store']);
        $this->middleware('rbac:class.edit')->only(['edit', 'update', 'sectionsByClass']);
        $this->middleware('rbac:class.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = SchoolClass::withCount(['sections', 'students'])->latest()->paginate(25);
        return view('admin.classes.index', compact('records'));
    }

    public function create()
    {
        return view('admin.classes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'class' => 'required|string|max:50',
            'note' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        SchoolClass::create($data);
        return redirect()->route('admin.class.index')->with('success', __('Class created.'));
    }

    public function show(SchoolClass $class)
    {
        $record = $class;
        $record->load(['sections.section', 'students']);
        return view('admin.classes.show', compact('record'));
    }

    public function edit(SchoolClass $class)
    {
        $record = $class;
        return view('admin.classes.edit', compact('record'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $data = $request->validate([
            'class' => 'required|string|max:50',
            'note' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        $class->update($data);
        return redirect()->route('admin.class.index')->with('success', __('Class updated.'));
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return redirect()->route('admin.class.index')->with('success', __('Class deleted.'));
    }

    /**
     * Return sections for a given class as JSON.
     * Called from AJAX dropdowns in student forms.
     */
    public function sectionsByClass(int $classId)
    {
        $sections = Section::whereHas('classSections', function ($q) use ($classId) {
            $q->where('class_id', $classId);
        })->pluck('section', 'id');

        return response()->json($sections);
    }
}
