<?php

/**
 * Smart Academy — Web routes.
 *
 * Replaces the CI3 routes.php + implicit controller routing.
 * Original codebase had 210 controllers; here we group them by:
 *   - frontend (public site + front-CMS)
 *   - auth (admin/student/parent login)
 *   - admin (resourceful admin controllers under App\Http\Controllers\Admin)
 *   - student (student/parent portal)
 *   - online-admission
 *   - gateway (IPN callbacks)
 *   - cron / webhooks
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{
    AdminLoginController,
    StudentLoginController,
    ForgotPasswordController,
    ResetPasswordController,
};
use App\Http\Controllers\{
    WelcomeController,
    SiteController,
    CronController,
    WebhooksController,
};

// ─── Public / Front-CMS ────────────────────────────────────────────
Route::group(['middleware' => ['web']], function (): void {

    Route::get('/',                 [WelcomeController::class, 'index'])->name('home');
    Route::get('/page/{slug}',      [WelcomeController::class, 'readPage'])->name('page.read');
    Route::get('/annual-calendar',  [WelcomeController::class, 'annualCalendar'])->name('page.calendar');
    Route::get('/admission',        [WelcomeController::class, 'admissionForm'])->name('page.admission');
    Route::post('/admission',       [WelcomeController::class, 'submitAdmission'])->name('page.admission.submit');
    Route::get('/online-admission', [WelcomeController::class, 'onlineAdmissionList'])->name('page.admission.list');
    Route::get('/examresult',       [WelcomeController::class, 'examResult'])->name('page.examresult');

    // ─── Admin login ──────────────────────────────────────────────
    Route::get('/site/login',               [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/site/login',              [AdminLoginController::class, 'login']);
    Route::post('/site/logout',             [AdminLoginController::class, 'logout'])->name('admin.logout');
    Route::get('/site/forgotpassword',      [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
    Route::post('/site/forgotpassword',     [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
    Route::get('/site/resetpassword/{token}',[ResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
    Route::post('/site/resetpassword',      [ResetPasswordController::class, 'reset'])->name('admin.password.update');

    // ─── Student / parent login ──────────────────────────────────
    Route::get('/site/userlogin',           [StudentLoginController::class, 'showLoginForm'])->name('student.login');
    Route::post('/site/userlogin',          [StudentLoginController::class, 'login']);
    Route::post('/site/userlogout',         [StudentLoginController::class, 'logout'])->name('student.logout');
    Route::get('/site/ufpassword',          [ForgotPasswordController::class, 'showUserLinkRequestForm'])->name('student.password.request');
    Route::post('/site/ufpassword',         [ForgotPasswordController::class, 'sendUserResetLinkEmail'])->name('student.password.email');
    Route::get('/site/resetpassword_user/{token}', [ResetPasswordController::class, 'showUserResetForm'])->name('student.password.reset');
    Route::post('/site/resetpassword_user', [ResetPasswordController::class, 'resetUser'])->name('student.password.update');
});

// ─── Admin panel ───────────────────────────────────────────────────
Route::group([
    'prefix'     => 'admin',
    'middleware' => ['web', 'auth.admin', 'rbac', 'fee.lock'],
    'namespace'  => 'App\\Http\\Controllers\\Admin',
    'as'         => 'admin.',
], function (): void {

    require __DIR__ . '/admin.php';
});

// ─── Student / parent portal ───────────────────────────────────────
Route::group([
    'prefix'     => 'user',
    'middleware' => ['web', 'auth.student'],
    'namespace'  => 'App\\Http\\Controllers\\Student',
    'as'         => 'student.',
], function (): void {

    require __DIR__ . '/student.php';
});

// ─── Online admission (public, rate-limited) ───────────────────────
Route::group([
    'prefix'     => 'online-admission',
    'middleware' => ['web', 'throttle.online'],
    'namespace'  => 'App\\Http\\Controllers\\OnlineAdmission',
    'as'         => 'online_admission.',
], function (): void {

    require __DIR__ . '/online_admission.php';
});

// ─── Gateway IPN callbacks (no CSRF) ────────────────────────────────
Route::group([
    'prefix'     => 'gateway',
    'namespace'  => 'App\\Http\\Controllers\\Gateway',
    'as'         => 'gateway.',
], function (): void {

    require __DIR__ . '/gateway.php';
});

// ─── Cron endpoints (key-protected) ─────────────────────────────────
Route::group(['prefix' => 'cron', 'as' => 'cron.'], function (): void {
    Route::get('/feereminder/{key}',       [CronController::class, 'feeReminder'])->name('feereminder');
    Route::get('/birthdaysms/{key}',      [CronController::class, 'birthdaySms'])->name('birthday');
    Route::get('/absentsms/{key}',        [CronController::class, 'absentSms'])->name('absent');
    Route::get('/salaryreminder/{key}',    [CronController::class, 'salaryReminder'])->name('salary');
    Route::get('/examreport/{key}',       [CronController::class, 'examReport'])->name('examreport');
    Route::get('/inactivestudent/{key}',  [CronController::class, 'inactiveStudent'])->name('inactive');
    Route::get('/attendanceupdate/{key}', [CronController::class, 'attendanceUpdate'])->name('attendance');
});

// ─── Webhooks (Firebase, payment providers, etc.) ──────────────────
Route::group(['prefix' => 'webhooks', 'as' => 'webhooks.'], function (): void {
    Route::post('/firebase',     [WebhooksController::class, 'firebase'])->name('firebase');
    Route::post('/paypal',       [WebhooksController::class, 'paypal'])->name('paypal');
    Route::post('/stripe',       [WebhooksController::class, 'stripe'])->name('stripe');
    Route::post('/biometric',    [WebhooksController::class, 'biometric'])->name('biometric');
});

// ─── Front-CMS routes (loaded from a separate file) ────────────────
require __DIR__ . '/front.php';
