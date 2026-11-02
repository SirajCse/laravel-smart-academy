<?php

namespace App\Listeners;

use App\Events\StudentEnrolled;
use App\Services\MailgatewayService;
use App\Services\SmsgatewayService;

class NotifyParentsOnEnrollment
{
    public function __construct(
        private MailgatewayService $mail,
        private SmsgatewayService $sms,
    ) {}

    public function handle(StudentEnrolled $event): void
    {
        $student = $event->student;

        if ($student->guardian_email) {
            $this->mail->send(
                $student->guardian_email,
                __(':student has been enrolled', ['student' => $student->firstname]),
                'emails.student-enrolled',
                ['student' => $student],
            );
        }

        if ($student->guardian_phone) {
            $this->sms->send($student->guardian_phone, "Dear {$student->guardian_name}, your child {$student->firstname} has been successfully enrolled at " . config('app.name'));
        }
    }
}
