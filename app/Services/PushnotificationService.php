<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Push notification service — replaces CI3's `Pushnotification` library.
 *
 * Wraps Firebase Cloud Messaging (FCM) HTTP v1 API for sending push
 * notifications to mobile devices. The Firebase service-account JSON
 * path is configured via `FIREBASE_CREDENTIALS_JSON` env variable.
 */
class PushnotificationService
{
    private ?string $accessToken = null;

    public function send(array $tokens, string $title, string $body, array $data = []): array
    {
        if (empty($tokens)) return ['success' => 0, 'failure' => 0];

        $token = $this->getAccessToken();
        if (! $token) {
            Log::error('FCM access token unavailable');
            return ['success' => 0, 'failure' => count($tokens)];
        }

        $projectId = config('firebase.project_id', 'smart-academy');
        $endpoint = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        $success = 0; $failure = 0;
        foreach ($tokens as $deviceToken) {
            $payload = [
                'message' => [
                    'token' => $deviceToken,
                    'notification' => ['title' => $title, 'body' => $body],
                    'data' => array_map('strval', $data),
                ],
            ];

            try {
                $resp = Http::withToken($token)->post($endpoint, $payload);
                if ($resp->successful()) {
                    $success++;
                } else {
                    Log::warning('FCM send failed', ['token' => $deviceToken, 'body' => $resp->body()]);
                    $failure++;
                }
            } catch (\Throwable $e) {
                Log::error('FCM exception', ['msg' => $e->getMessage()]);
                $failure++;
            }
        }

        return ['success' => $success, 'failure' => $failure];
    }

    public function sendToTopic(string $topic, string $title, string $body, array $data = []): bool
    {
        $token = $this->getAccessToken();
        if (! $token) return false;

        $projectId = config('firebase.project_id', 'smart-academy');
        $endpoint = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        $payload = [
            'message' => [
                'topic' => $topic,
                'notification' => ['title' => $title, 'body' => $body],
                'data' => array_map('strval', $data),
            ],
        ];

        try {
            $resp = Http::withToken($token)->post($endpoint, $payload);
            return $resp->successful();
        } catch (\Throwable $e) {
            Log::error('FCM topic send failed', ['msg' => $e->getMessage()]);
            return false;
        }
    }

    private function getAccessToken(): ?string
    {
        if ($this->accessToken) return $this->accessToken;

        $credentialsPath = config('firebase.credentials_json', env('FIREBASE_CREDENTIALS_JSON'));
        if (! $credentialsPath || ! file_exists($credentialsPath)) {
            return null;
        }

        try {
            $client = new \Google_Client();
            $client->setAuthConfig($credentialsPath);
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $this->accessToken = $client->fetchAccessTokenWithAssertion()['access_token'] ?? null;
            return $this->accessToken;
        } catch (\Throwable $e) {
            Log::error('Firebase auth failed', ['msg' => $e->getMessage()]);
            return null;
        }
    }
}
