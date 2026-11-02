<?php

/**
 * Front-CMS routes (public site).
 * Replaces CI3 controllers/welcome.php + application/views/themes/{theme}/* (8 themes).
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\{
    PageController,
    NewsController,
    EventController,
    GalleryController,
    AdmissionController,
    CalendarController,
    ExamResultController,
};

Route::get('/',                       [PageController::class, 'home'])->name('home');
Route::get('/page/{slug}',            [PageController::class, 'read'])->name('page.read');
Route::get('/news',                   [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}',           [NewsController::class, 'show'])->name('news.show');
Route::get('/events',                 [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}',          [EventController::class, 'show'])->name('events.show');
Route::get('/gallery',                [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{id}',          [GalleryController::class, 'show'])->name('gallery.show');
Route::get('/admission',             [AdmissionController::class, 'index'])->name('admission.index');
Route::post('/admission',            [AdmissionController::class, 'submit'])->name('admission.submit');
Route::get('/calendar',              [CalendarController::class, 'index'])->name('calendar.index');
Route::get('/exam-result',          [ExamResultController::class, 'index'])->name('examresult.index');
Route::post('/exam-result',         [ExamResultController::class, 'lookup'])->name('examresult.lookup');
