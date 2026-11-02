<?php

/**
 * Front-CMS routes (public site).
 * Routes here are loaded LAST (after web.php's front-CMS routes).
 * We register both 'front.*' (canonical) and legacy aliases ('home',
 * 'page.read', 'page.admission', etc.) so existing Blade views work.
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

Route::get('/',                       [PageController::class, 'home'])->name('front.home');
Route::get('/',                       [PageController::class, 'home'])->name('home');

Route::get('/page/{slug}',            [PageController::class, 'read'])->name('front.page.read');
Route::get('/page/{slug}',            [PageController::class, 'read'])->name('page.read');

Route::get('/news',                   [NewsController::class, 'index'])->name('front.news.index');
Route::get('/news/{slug}',           [NewsController::class, 'show'])->name('front.news.show');

Route::get('/events',                 [EventController::class, 'index'])->name('front.events.index');
Route::get('/events/{slug}',          [EventController::class, 'show'])->name('front.events.show');

Route::get('/gallery',                [GalleryController::class, 'index'])->name('front.gallery.index');
Route::get('/gallery/{id}',          [GalleryController::class, 'show'])->name('front.gallery.show');

Route::get('/admission',             [AdmissionController::class, 'index'])->name('front.admission.index');
Route::get('/admission',             [AdmissionController::class, 'index'])->name('page.admission');
Route::post('/admission',            [AdmissionController::class, 'submit'])->name('front.admission.submit');
Route::post('/admission',            [AdmissionController::class, 'submit'])->name('page.admission.submit');

Route::get('/calendar',              [CalendarController::class, 'index'])->name('front.calendar.index');
Route::get('/annual-calendar',       [CalendarController::class, 'index'])->name('page.calendar');

Route::get('/exam-result',          [ExamResultController::class, 'index'])->name('front.examresult.index');
Route::get('/examresult',           [ExamResultController::class, 'index'])->name('page.examresult');
Route::post('/exam-result',         [ExamResultController::class, 'lookup'])->name('front.examresult.lookup');

Route::get('/online-admission',     [PageController::class, 'home'])->name('page.admission.list');
