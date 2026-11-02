<?php

namespace App\Services;

use App\Models\EmailConfig;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

/**
 * Mail gateway service — replaces CI3's `Mailgateway` library.
 *
 * SMTP host/port/credentials are stored in the `email_config` DB table
 * (legacy behaviour) and applied at runtime to Laravel's mail config.
 */
class MailgatewayService
{
    public function send(string $to, string $subject, string $view, array $data = [], ?string $from = null, ?string $fromName = null): bool
    {
        $config = EmailConfig::where('is_active', 1)->first();

        if ($config) {
            config([
                'mail.mailer'          => $config->mailer ?: 'smtp',
                'mail.host'            => $config->smtp_host,
                'mail.port'            => $config->smtp_port,
                'mail.username'        => $config->smtp_username,
                'mail.password'        => $config->smtp_password,
                'mail.encryption'      => $config->encryption,
                'mail.from.address'    => $from ?: $config->from_email,
                'mail.from.name'       => $fromName ?: $config->from_name,
            ]);

            (new \Illuminate\Mail\MailServiceProvider(app()))->register();
        }

        try {
            Mail::send($view, $data, function ($message) use ($to, $subject, $from, $fromName) {
                $message->to($to)->subject($subject);
                if ($from) {
                    $message->from($from, $fromName ?: config('app.name'));
                }
            });
            return true;
        } catch (\Throwable $e) {
            Log::error('Mail send failed: ' . $e->getMessage(), ['to' => $to, 'subject' => $subject]);
            return false;
        }
    }

    public function sendRaw(string $to, string $subject, string $body): bool
    {
        try {
            Mail::raw($body, function ($message) use ($to, $subject) {
                $message->to($to)->subject($subject);
            });
            return true;
        } catch (\Throwable $e) {
            Log::error('Mail send raw failed: ' . $e->getMessage());
            return false;
        }
    }
}
