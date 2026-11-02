<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaypalController extends Controller
{
    public function __construct(private PaymentGatewayService $payments) {}

    public function ipn(Request $request)
    {
        Log::info('PayPal IPN', $request->all());
        return response('OK');
    }

    public function return(Request $request)
    {
        return redirect()->route('student.fees.index')->with('success', __('Payment completed.'));
    }

    public function cancel(Request $request)
    {
        return redirect()->route('student.fees.index')->with('error', __('Payment cancelled.'));
    }

    public function callback(Request $request)
    {
        Log::info('PAYPAL webhook received', $request->all());

        $result = $this->payments->complete('payment_provider', $request->all());

        if ($result['success'] ?? false) {
            // Update fee record
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'failed', 'message' => $result['message'] ?? ''], 400);
    }
}
