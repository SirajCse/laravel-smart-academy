<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Webhooks controller — handles incoming webhooks from payment gateways
 * and biometric devices.
 *
 * Replaces CI3 controllers/Webhooks.php
 */
class WebhooksController extends Controller
{
    public function firebase(Request $request)
    {
        Log::info('Firebase webhook', $request->all());
        return response()->json(['status' => 'ok']);
    }

    public function paypal(Request $request)
    {
        Log::info('PayPal webhook', $request->all());
        // Verify IPN, update StudentFees payment record
        return response('OK', 200);
    }

    public function stripe(Request $request)
    {
        $event = $request->all();
        Log::info('Stripe webhook', $event);

        switch ($event['type'] ?? '') {
            case 'payment_intent.succeeded':
                // Update fee record
                break;
        }

        return response()->json(['received' => true]);
    }

    public function biometric(Request $request)
    {
        Log::info('Biometric webhook', $request->all());
        // Sync staff attendance
        return response('OK', 200);
    }
}
