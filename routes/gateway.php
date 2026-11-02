<?php

/**
 * Payment gateway IPN/callback routes (no CSRF).
 * Replaces CI3 controllers/gateway_ins/* (6 controllers).
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Gateway\{
    PaypalController,
    StripeController,
    PaytmController,
    MidtransController,
    PesapalController,
    BillplzController,
    MpesaController,
    CcAvenueController,
    TwoCheckoutController,
};

Route::post('/paypal/ipn',         [PaypalController::class, 'ipn'])->name('paypal.ipn');
Route::get('/paypal/return',       [PaypalController::class, 'return'])->name('paypal.return');
Route::get('/paypal/cancel',      [PaypalController::class, 'cancel'])->name('paypal.cancel');

Route::post('/stripe/webhook',     [StripeController::class, 'webhook'])->name('stripe.webhook');

Route::post('/paytm/callback',    [PaytmController::class, 'callback'])->name('paytm.callback');

Route::post('/midtrans/notification', [MidtransController::class, 'notification'])->name('midtrans.notification');
Route::post('/midtrans/finish',        [MidtransController::class, 'finish'])->name('midtrans.finish');
Route::post('/midtrans/unfinish',      [MidtransController::class, 'unfinish'])->name('midtrans.unfinish');

Route::post('/pesapal/ipn',       [PesapalController::class, 'ipn'])->name('pesapal.ipn');

Route::post('/billplz/webhook',   [BillplzController::class, 'webhook'])->name('billplz.webhook');

Route::post('/mpesa/callback',    [MpesaController::class, 'callback'])->name('mpesa.callback');

Route::post('/ccavenue/response', [CcAvenueController::class, 'response'])->name('ccavenue.response');

Route::post('/twocheckout/ins',   [TwoCheckoutController::class, 'ins'])->name('twocheckout.ins');
