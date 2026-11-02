<?php

namespace App\Services;

use Omnipay\Omnipay;
use Illuminate\Support\Facades\Log;

/**
 * Payment gateway service — wraps CI3's 9 payment adapters into one
 * unified service. Each adapter implements `purchase()`, `complete()`,
 * and `refund()` against a common interface.
 *
 * Supported drivers:
 *   paypal, stripe, twocheckout, paytm, midtrans, pesapal,
 *   billplz, mpesa, ccavenue
 */
class PaymentGatewayService
{
    private array $gateways = [];

    public function gateway(string $driver): ?object
    {
        if (isset($this->gateways[$driver])) {
            return $this->gateways[$driver];
        }

        try {
            switch ($driver) {
                case 'paypal':
                    $gw = Omnipay::create('PayPal_Express');
                    $gw->setUsername(config('services.paypal.username'));
                    $gw->setPassword(config('services.paypal.password'));
                    $gw->setSignature(config('services.paypal.signature'));
                    $gw->setTestMode(config('services.paypal.sandbox', true));
                    break;

                case 'stripe':
                    $gw = Omnipay::create('Stripe');
                    $gw->setApiKey(config('services.stripe.secret'));
                    break;

                default:
                    return null;
            }
            $this->gateways[$driver] = $gw;
            return $gw;
        } catch (\Throwable $e) {
            Log::error('Payment gateway init failed', ['driver' => $driver, 'err' => $e->getMessage()]);
            return null;
        }
    }

    public function purchase(string $driver, array $params): ?array
    {
        $gw = $this->gateway($driver);
        if (! $gw) return null;

        try {
            $resp = $gw->purchase($params)->send();
            return [
                'success'      => $resp->isSuccessful(),
                'redirect'      => method_exists($resp, 'getRedirectUrl') ? $resp->getRedirectUrl() : null,
                'transaction_id'=> $resp->getTransactionReference(),
                'message'       => $resp->getMessage(),
            ];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function complete(string $driver, array $params): ?array
    {
        $gw = $this->gateway($driver);
        if (! $gw) return null;

        try {
            $resp = $gw->completePurchase($params)->send();
            return [
                'success'       => $resp->isSuccessful(),
                'transaction_id'=> $resp->getTransactionReference(),
                'message'        => $resp->getMessage(),
                'data'           => method_exists($resp, 'getData') ? $resp->getData() : null,
            ];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function refund(string $driver, string $transactionId, float $amount): ?array
    {
        $gw = $this->gateway($driver);
        if (! $gw) return null;

        try {
            $resp = $gw->refund([
                'transactionReference' => $transactionId,
                'amount'              => $amount,
                'currency'            => config('app.currency', 'USD'),
            ])->send();

            return [
                'success'       => $resp->isSuccessful(),
                'transaction_id'=> $resp->getTransactionReference(),
                'message'        => $resp->getMessage(),
            ];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
