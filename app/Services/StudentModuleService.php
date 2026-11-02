<?php

namespace App\Services;

use App\Models\StudentSession;
use App\Models\Student;
use App\Models\StudentFeesMaster;
use App\Models\StudentAttendence;
use App\Models\Homework;
use App\Models\ExamResult;

/**
 * Student module service — replaces CI3's `Studentmodule_lib` library.
 *
 * Aggregates the per-student queries used across the student portal:
 * dashboard stats, fee summary, attendance %, exam results, homework list.
 */
class StudentModuleService
{
    public function dashboard(int $studentId): array
    {
        $session = app(Customlib::class)->getStudentCurrentSession($studentId);
        $sessionId = $session?->session_id ?: app(Customlib::class)->getActiveSessionId();

        return [
            'session'           => $session,
            'fees_summary'      => $this->feesSummary($studentId, $sessionId),
            'attendance_pct'    => $this->attendancePercentage($session?->id),
            'homework_count'    => $this->homeworkCount($session),
            'exam_results'      => $this->examResults($session),
        ];
    }

    public function feesSummary(int $studentId, int $sessionId): array
    {
        $session = StudentSession::where('student_id', $studentId)
            ->where('session_id', $sessionId)
            ->first();

        if (! $session) {
            return ['total' => 0, 'paid' => 0, 'due' => 0, 'discount' => 0];
        }

        $masters = StudentFeesMaster::where('student_session_id', $session->id)->get();
        $total = $masters->sum('amount');
        $discount = $masters->sum('discount_amount');
        $paid = $masters->flatMap->payments->sum('amount');
        $due = $total - $discount - $paid;

        return [
            'total'    => (float) $total,
            'paid'     => (float) $paid,
            'discount' => (float) $discount,
            'due'      => (float) max(0, $due),
        ];
    }

    public function attendancePercentage(?int $studentSessionId): float
    {
        if (! $studentSessionId) return 0.0;

        $total = StudentAttendence::where('student_session_id', $studentSessionId)->count();
        if ($total === 0) return 0.0;

        $present = StudentAttendence::where('student_session_id', $studentSessionId)
            ->whereHas('type', fn ($q) => $q->where('short_code', 'P'))
            ->count();

        return round(($present / $total) * 100, 2);
    }

    public function homeworkCount(?StudentSession $session): int
    {
        if (! $session) return 0;
        return Homework::where('class_id', $session->class_id)
            ->where('section_id', $session->section_id)
            ->where('session_id', $session->session_id)
            ->count();
    }

    public function examResults(?StudentSession $session): array
    {
        if (! $session) return [];
        return ExamResult::where('student_session_id', $session->id)
            ->with(['schedule.exam', 'schedule.subject'])
            ->get()
            ->groupBy(fn ($r) => $r->schedule?->exam?->name ?: 'Unknown')
            ->map(fn ($rows) => $rows->map(fn ($r) => [
                'subject' => $r->schedule?->subject?->name,
                'marks'   => (float) $r->get_marks,
                'full_marks' => (float) $r->schedule?->full_marks,
                'is_absent' => (bool) $r->is_absent,
            ]))
            ->all();
    }
}
