<?php

/**
 * Online admission routes (public, rate-limited).
 * Replaces CI3 controllers/onlineadmission/* (24 controllers).
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnlineAdmission\{
    OnlineAdmissionController,
    PaymentController,
    ReviewController,
    StatusController,
};

Route::get('/',                          [OnlineAdmissionController::class, 'index'])->name('index');
Route::post('/',                         [OnlineAdmissionController::class, 'store']);
Route::get('/review/{reference}',        [ReviewController::class, 'show'])->name('review');
Route::post('/review/{reference}/submit', [ReviewController::class, 'submit']);

Route::get('/pay/{reference}',          [PaymentController::class, 'show'])->name('pay');
Route::post('/pay/{reference}/process', [PaymentController::class, 'process']);
Route::get('/pay/{reference}/success',  [PaymentController::class, 'success'])->name('pay.success');
Route::post('/pay/{reference}/notify',  [PaymentController::class, 'notify'])->name('pay.notify');
Route::get('/pay/{reference}/cancel',   [PaymentController::class, 'cancel'])->name('pay.cancel');

Route::get('/status/{reference}',       [StatusController::class, 'show'])->name('status');
