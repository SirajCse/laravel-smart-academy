<?php

namespace App\Console\Commands;

use App\Models\StudentFeesMaster;
use App\Services\SmsgatewayService;
use App\Services\MailgatewayService;
use App\Services\PushnotificationService;
use Illuminate\Console\Command;

class SendFeeReminder extends Command
{
    protected $signature = 'fees:reminder {--dry-run}';
    protected $description = 'Send fee reminders to students with due fees.';

    public function handle(): int
    {
        $masters = StudentFeesMaster::whereHas('payments', function ($q) {
            $q->where('date', '<', today());
        })->with('studentSession.student.user')->get();

        $count = 0;
        foreach ($masters as $master) {
            $student = $master->studentSession?->student;
            if (! $student) continue;

            if ($this->option('dry-run')) {
                $this->line("DRY: Would send reminder to {$student->firstname} (phone: {$student->mobileno})");
                $count++;
                continue;
            }

            app(SmsgatewayService::class)->send($student->mobileno, "Dear {$student->firstname}, your fee of {$master->amount} is due. Please pay before due date.");

            if ($student->email) {
                app(MailgatewayService::class)->send($student->email, 'Fee Reminder', 'emails.fee-reminder', ['student' => $student, 'fee' => $master]);
            }

            if ($student->user?->device_token) {
                app(PushnotificationService::class)->send([$student->user->device_token], 'Fee Reminder', 'Your fee is due.');
            }

            $count++;
        }

        $this->info("Sent {$count} fee reminders.");
        return self::SUCCESS;
    }
}
