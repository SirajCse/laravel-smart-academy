<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CcAvenueController extends Controller
{
    public function __construct(private PaymentGatewayService $payments) {}

    public function callback(Request $request)
    {
        Log::info('CCAVENUE webhook received', $request->all());

        $result = $this->payments->complete('payment_provider', $request->all());

        if ($result['success'] ?? false) {
            // Update fee record
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'failed', 'message' => $result['message'] ?? ''], 400);
    }
}
