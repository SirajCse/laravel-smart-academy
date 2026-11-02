<?php

namespace App\Mail;

use App\Models\Staff;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StaffPasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Staff $staff, public string $token) {}

    public function envelope(): \Illuminate\Mail\Envelope
    {
        return new \Illuminate\Mail\Envelope(
            subject: __('Password Reset - :app', ['app' => config('app.name')]),
        );
    }

    public function content(): \Illuminate\Mail\Content
    {
        return new \Illuminate\Mail\Content(
            markdown: 'emails.staff-reset',
            with: [
                'resetUrl' => route('admin.password.reset', ['token' => $this->token]) . '?email=' . urlencode($this->staff->email),
            ],
        );
    }
}
