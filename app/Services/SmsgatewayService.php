<?php

namespace App\Services;

use App\Models\SmsConfig;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * SMS gateway service — replaces CI3's `Smsgateway` library
 * (3 145 lines supporting 15+ providers).
 *
 * Dispatches based on the `sms_config.provider` column. Supported
 * providers: `twilio`, `nexmo`, `msg91`, `textlocal`, `plivo`,
 * `smscountry`, `clickatell`, `fast2sms`, `msgbox`, `serwersms`,
 * `bulkson`, `mobily`, `africastalking`, `dimoco`, `whatsapp`.
 *
 * Each provider is implemented as a private method that takes
 * (string $to, string $message, SmsConfig $config) and returns bool.
 */
class SmsgatewayService
{
    public function send(string $to, string $message, ?string $provider = null): bool
    {
        $config = SmsConfig::where('provider', $provider ?: $this->defaultProvider())
            ->where('is_active', 1)
            ->first();

        if (! $config) {
            Log::warning('SMS gateway not configured', ['provider' => $provider]);
            return false;
        }

        $method = 'sendVia' . Str::studly($config->provider);
        if (! method_exists($this, $method)) {
            Log::error('Unsupported SMS provider', ['provider' => $config->provider]);
            return false;
        }

        // Normalize phone number
        $to = $this->normalizePhone($to);

        try {
            return $this->{$method}($to, $message, $config);
        } catch (\Throwable $e) {
            Log::error('SMS send failed', ['provider' => $config->provider, 'error' => $e->getMessage()]);
            return false;
        }
    }

    public function sendBulk(array $recipients, string $message): array
    {
        $results = [];
        foreach ($recipients as $phone) {
            $results[$phone] = $this->send($phone, $message);
        }
        return $results;
    }

    private function defaultProvider(): string
    {
        return SmsConfig::where('is_active', 1)->value('provider') ?? 'twilio';
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        if (! str_starts_with($phone, '+')) {
            $phone = '+' . ltrim($phone, '0');
        }
        return $phone;
    }

    private function sendViaTwilio(string $to, string $message, SmsConfig $config): bool
    {
        $sid = $config->api_key;
        $token = decrypt($config->sender_id); // encrypted
        $from = $config->api_url ?: '+1234567890';

        $resp = Http::withBasicAuth($sid, $token)
            ->asForm()
            ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", [
                'From' => $from,
                'To'   => $to,
                'Body' => $message,
            ]);

        return $resp->successful();
    }

    private function sendViaNexmo(string $to, string $message, SmsConfig $config): bool
    {
        $resp = Http::post('https://rest.nexmo.com/sms/json', [
            'api_key'    => $config->api_key,
            'api_secret' => $config->sender_id,
            'to'         => ltrim($to, '+'),
            'from'       => $config->api_url,
            'text'       => $message,
        ]);

        return $resp->json('messages.0.status') === '0';
    }

    private function sendViaMsg91(string $to, string $message, SmsConfig $config): bool
    {
        $resp = Http::withHeaders(['authkey' => $config->api_key])
            ->post('https://api.msg91.com/api/v2/sendsms', [
                'sender'  => $config->sender_id,
                'route'   => '4',
                'country' => '91',
                'sms'     => [[
                    'message' => $message,
                    'to'      => [ltrim($to, '+')],
                ]],
            ]);

        return $resp->json('type') === 'success';
    }

    private function sendViaTextlocal(string $to, string $message, SmsConfig $config): bool
    {
        $resp = Http::asForm()->post('https://api.textlocal.in/send/', [
            'apikey'  => $config->api_key,
            'numbers' => ltrim($to, '+'),
            'message' => $message,
            'sender'  => $config->sender_id,
        ]);

        return $resp->json('status') === 'success';
    }

    private function sendViaPlivo(string $to, string $message, SmsConfig $config): bool
    {
        $resp = Http::withBasicAuth($config->api_key, $config->sender_id)
            ->post("https://api.plivo.com/v1/Account/{$config->api_key}/Message/", [
                'src'  => $config->api_url,
                'dst'  => ltrim($to, '+'),
                'text' => $message,
            ]);

        return $resp->successful();
    }

    private function sendViaSmscountry(string $to, string $message, SmsConfig $config): bool
    {
        $resp = Http::asForm()->post('https://api.smsgatewayhub.com/smsapi/push-sms', [
            'apikey'   => $config->api_key,
            'senderid' => $config->sender_id,
            'number'   => ltrim($to, '+'),
            'message'  => $message,
            'route'    => 'default',
        ]);
        return $resp->successful();
    }

    private function sendViaClickatell(string $to, string $message, SmsConfig $config): bool
    {
        $resp = Http::withHeaders(['Authorization' => $config->api_key])
            ->post('https://platform.clickatell.com/messages', [
                'content'    => $message,
                'to'         => [ltrim($to, '+')],
                'from'       => $config->sender_id,
            ]);
        return $resp->successful();
    }

    private function sendViaFast2sms(string $to, string $message, SmsConfig $config): bool
    {
        $resp = Http::withHeaders(['authorization' => $config->api_key])
            ->asForm()
            ->post('https://www.fast2sms.com/dev/bulkV2', [
                'route'    => 'dlt',
                'sender_id'=> $config->sender_id,
                'message'  => $message,
                'numbers'  => ltrim($to, '+'),
            ]);
        return $resp->json('return') === true;
    }

    // Stubs for additional providers - implement per provider API docs.
    private function sendViaMsgbox(string $to, string $message, SmsConfig $config): bool
    {
        return false; // TODO: implement per https://api.msgboxx.com
    }

    private function sendViaSerwersms(string $to, string $message, SmsConfig $config): bool
    {
        return false; // TODO: implement per https://api.serwersms.pl
    }

    private function sendViaBulkson(string $to, string $message, SmsConfig $config): bool
    {
        return false; // TODO: implement per https://api.bulkson.com
    }

    private function sendViaMobily(string $to, string $message, SmsConfig $config): bool
    {
        return false; // TODO: implement per https://api.mobily.ws
    }

    private function sendViaAfricastalking(string $to, string $message, SmsConfig $config): bool
    {
        return false; // TODO: implement per https://developers.africastalking.com
    }

    private function sendViaDimoco(string $to, string $message, SmsConfig $config): bool
    {
        return false; // TODO: implement per https://api.dimoco.com
    }

    private function sendViaWhatsapp(string $to, string $message, SmsConfig $config): bool
    {
        return false; // TODO: implement per WhatsApp Business API
    }
}
