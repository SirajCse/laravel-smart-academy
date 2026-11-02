<?php

/**
 * Student / parent portal routes.
 * Replaces CI3 controllers/user/* (25 controllers).
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\{
    DashboardController,
    ProfileController,
    HomeworkController,
    AttendanceController,
    ExamController,
    FeeController,
    ApplyLeaveController,
    BookController,
    BookIssueController,
    NotificationController,
    ChatController,
    TransportController,
    HostelController,
    OnlineExamController,
    TimetableController,
    DownloadController,
    ChangePasswordController,
};

Route::get('/dashboard',                  [DashboardController::class, 'index'])->name('dashboard');

// Profile
Route::get('/profile',                    [ProfileController::class, 'index'])->name('profile');
Route::post('/profile',                   [ProfileController::class, 'update']);
Route::post('/profile/photo',             [ProfileController::class, 'uploadPhoto']);

// Homework
Route::resource('homework',               HomeworkController::class);
Route::post('homework/{id}/submit',       [HomeworkController::class, 'submit']);

// Attendance
Route::get('/attendance',                 [AttendanceController::class, 'index'])->name('attendance.index');

// Exams
Route::resource('exam',                   ExamController::class);
Route::get('exam/{id}/result',           [ExamController::class, 'result']);

// Fees
Route::get('/fees',                       [FeeController::class, 'index'])->name('fees.index');
Route::get('/fees/{id}',                  [FeeController::class, 'show'])->name('fees.show');
Route::post('/fees/{id}/pay',             [FeeController::class, 'pay']);
Route::get('/fees/{id}/invoice',         [FeeController::class, 'invoice']);

// Apply leave
Route::resource('apply-leave',            ApplyLeaveController::class);

// Library
Route::resource('book',                   BookController::class);
Route::resource('book-issue',             BookIssueController::class);

// Notifications
Route::resource('notification',           NotificationController::class);
Route::post('notification/{id}/read',     [NotificationController::class, 'markRead']);

// Chat
Route::resource('chat',                   ChatController::class);

// Transport
Route::get('/transport',                  [TransportController::class, 'index'])->name('transport.index');

// Hostel
Route::get('/hostel',                     [HostelController::class, 'index'])->name('hostel.index');

// Online exam
Route::resource('online-exam',            OnlineExamController::class);

// Timetable
Route::get('/timetable',                  [TimetableController::class, 'index'])->name('timetable.index');

// Downloads
Route::get('/download/{id}',              [DownloadController::class, 'download'])->name('download');

// Change password
Route::get('/change-password',            [ChangePasswordController::class, 'index'])->name('change_password.index');
Route::post('/change-password',           [ChangePasswordController::class, 'update']);
