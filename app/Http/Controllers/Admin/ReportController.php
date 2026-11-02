<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Student, StudentFees, StudentAttendence, BookIssue, InventoryItem, Alumni};
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:reports.view');
    }

    public function student(Request $request)
    {
        $records = Student::with(['sessions.class', 'sessions.section'])->latest()->paginate(25);
        return view('admin.reports.student', compact('records'));
    }

    public function fee(Request $request)
    {
        $records = StudentFees::with(['master.studentSession.student'])->latest()->paginate(25);
        return view('admin.reports.fee', compact('records'));
    }

    public function attendance(Request $request)
    {
        $records = StudentAttendence::with(['studentSession.student', 'type'])->latest()->paginate(25);
        return view('admin.reports.attendance', compact('records'));
    }

    public function exam(Request $request)
    {
        $records = \App\Models\ExamResult::with(['schedule.exam', 'schedule.subject', 'studentSession.student'])->latest()->paginate(25);
        return view('admin.reports.exam', compact('records'));
    }

    public function library(Request $request)
    {
        $records = BookIssue::with(['book'])->latest()->paginate(25);
        return view('admin.reports.library', compact('records'));
    }

    public function inventory(Request $request)
    {
        $records = InventoryItem::with(['category'])->latest()->paginate(25);
        return view('admin.reports.inventory', compact('records'));
    }

    public function alumni(Request $request)
    {
        $records = Alumni::with(['student'])->latest()->paginate(25);
        return view('admin.reports.alumni', compact('records'));
    }
}
