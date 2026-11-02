<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Customlib;
use App\Services\StudentModuleService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private Customlib $customlib,
        private StudentModuleService $studentModule,
    ) {}

    public function index()
    {
        $user = auth('student')->user();
        $student = \App\Models\Student::find($user->user_id);

        if (! $student) {
            return redirect()->route('student.logout');
        }

        $dashboard = $this->studentModule->dashboard($student->id);

        return view('student.dashboard', [
            'fees'           => $dashboard['fees_summary'],
            'attendancePct'  => $dashboard['attendance_pct'],
            'homeworks'       => \App\Models\Homework::whereHas('schedule', function ($q) use ($dashboard) {
                $session = $dashboard['session'];
                if ($session) {
                    $q->where('class_id', $session->class_id)
                      ->where('section_id', $session->section_id);
                }
            })->limit(5)->get(),
            'notifications'  => \App\Models\Notification::where('user_id', $user->id)->latest()->limit(5)->get(),
        ]);
    }
}
