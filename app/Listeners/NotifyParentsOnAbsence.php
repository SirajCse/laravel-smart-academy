<?php

namespace App\Listeners;

use App\Events\AttendanceMarked;
use App\Services\MailgatewayService;
use App\Services\SmsgatewayService;

class NotifyParentsOnAbsence
{
    public function __construct(
        private MailgatewayService $mail,
        private SmsgatewayService $sms,
    ) {}

    public function handle(AttendanceMarked $event): void
    {
        $attendance = $event->attendance;

        // Only notify for absent / half-day
        $typeCode = $attendance->type?->short_code;
        if (! in_array($typeCode, ['A', 'H'])) return;

        $student = $attendance->studentSession?->student;
        if (! $student) return;

        if ($student->guardian_phone) {
            $this->sms->send($student->guardian_phone, "Dear {$student->guardian_name}, your child {$student->firstname} was marked absent today ({$attendance->date}).");
        }

        if ($student->guardian_email) {
            $this->mail->send($student->guardian_email, __('Attendance Notification'), 'emails.absent', ['student' => $student, 'attendance' => $attendance]);
        }
    }
}
