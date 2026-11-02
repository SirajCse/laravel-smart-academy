<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentSession;
use Illuminate\Http\Request;

class StudentSessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:student.view');
    }

    public function index(Request $request)
    {
        $records = StudentSession::with(['student', 'class', 'section', 'session'])->latest()->paginate(25);
        return view('admin.student-session.index', compact('records'));
    }

    public function show(StudentSession $student_session)
    {
        $record = $student_session;
        $record->load(['student', 'class', 'section', 'session']);
        return view('admin.student-session.show', compact('record'));
    }
}
