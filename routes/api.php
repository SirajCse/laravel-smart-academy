<?php

/**
 * API routes — used by the mobile app and the legacy Datatables endpoints.
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    StudentApiController,
    ParentApiController,
    StaffApiController,
    NotificationApiController,
    FeeApiController,
    AttendanceApiController,
    HomeworkApiController,
    ExamApiController,
    ChatApiController,
    LibraryApiController,
    TransportApiController,
    HostelApiController,
    PayApiController,
    AppUpdateController,
};

Route::group(['middleware' => ['api']], function (): void {

    // Auth (open)
    Route::post('/login',         [AuthController::class, 'login']);
    Route::post('/forgot',       [AuthController::class, 'forgot']);
    Route::post('/register-device', [AuthController::class, 'registerDevice']);

    // Public read endpoints
    Route::get('/app/version',   [AppUpdateController::class, 'version']);
    Route::get('/app/config',    [AppUpdateController::class, 'config']);
});

Route::group(['middleware' => ['api', 'auth:sanctum']], function (): void {

    Route::post('/logout',       [AuthController::class, 'logout']);
    Route::get('/me',            [AuthController::class, 'me']);

    Route::get('/dashboard',     [StudentApiController::class, 'dashboard']);
    Route::get('/profile',       [StudentApiController::class, 'profile']);
    Route::post('/profile',      [StudentApiController::class, 'updateProfile']);

    Route::get('/homework',      [HomeworkApiController::class, 'index']);
    Route::post('/homework/{id}/submit', [HomeworkApiController::class, 'submit']);

    Route::get('/attendance',    [AttendanceApiController::class, 'index']);
    Route::get('/fees',          [FeeApiController::class, 'index']);
    Route::post('/fees/{id}/pay', [FeeApiController::class, 'pay']);

    Route::get('/exams',         [ExamApiController::class, 'index']);
    Route::get('/exams/{id}/result', [ExamApiController::class, 'result']);

    Route::get('/notifications', [NotificationApiController::class, 'index']);
    Route::post('/notifications/{id}/read', [NotificationApiController::class, 'markRead']);

    Route::get('/library',       [LibraryApiController::class, 'index']);
    Route::get('/transport',     [TransportApiController::class, 'index']);
    Route::get('/hostel',        [HostelApiController::class, 'index']);

    Route::get('/chat',          [ChatApiController::class, 'index']);
    Route::post('/chat/send',    [ChatApiController::class, 'send']);

    // Parent endpoints
    Route::get('/parent/children',     [ParentApiController::class, 'children']);
    Route::get('/parent/children/{id}', [ParentApiController::class, 'child']);

    // Staff endpoints
    Route::get('/staff/dashboard',     [StaffApiController::class, 'dashboard']);
    Route::get('/staff/students',      [StaffApiController::class, 'students']);
    Route::post('/staff/attendance',   [StaffApiController::class, 'markAttendance']);

    // Pay endpoint (mobile unified checkout)
    Route::post('/pay/init',           [PayApiController::class, 'init']);
    Route::post('/pay/verify',         [PayApiController::class, 'verify']);
});

// Datatables endpoints (admin panel uses these)
Route::group(['middleware' => ['api', 'auth:admin']], function (): void {
    Route::get('/datatables/students',        [StudentApiController::class, 'datatable']);
    Route::get('/datatables/staff',            [StaffApiController::class, 'datatable']);
    Route::get('/datatables/books',            [LibraryApiController::class, 'datatable']);
    Route::get('/datatables/fees',             [FeeApiController::class, 'datatable']);
    Route::get('/datatables/attendance',       [AttendanceApiController::class, 'datatable']);
});
