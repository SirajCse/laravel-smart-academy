<?php

namespace App\Listeners;

use App\Events\FeePaymentReceived;
use App\Services\MailgatewayService;

class SendFeeReceipt
{
    public function __construct(private MailgatewayService $mail) {}

    public function handle(FeePaymentReceived $event): void
    {
        $fee = $event->fee;
        $student = $fee->master?->studentSession?->student;
        if (! $student || ! $student->email) return;

        $this->mail->send(
            $student->email,
            __('Fee Receipt - :app', ['app' => config('app.name')]),
            'emails.fee-receipt',
            ['fee' => $fee, 'student' => $student],
        );
    }
}
