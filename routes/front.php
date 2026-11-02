<?php

/**
 * Front-CMS routes (public site).
 * Replaces CI3 controllers/welcome.php + application/views/themes/{theme}/* (8 themes).
 *
 * NOTE: routes here are loaded LAST (after web.php's front-CMS routes),
 * which means they OVERRIDE the same URIs registered in web.php.
 * To preserve backward compatibility, we register the legacy names
 * (`home`, `page.read`, `page.admission`, etc.) as additional aliases
 * pointing to the same controller actions.
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

// Home — registered as both 'front.home' (canonical) and 'home' (legacy alias)
Route::get('/',                       [PageController::class, 'home'])->name('front.home');
Route::get('/',                       [PageController::class, 'home'])->name('home');

// Pages
Route::get('/page/{slug}',            [PageController::class, 'read'])->name('front.page.read');
Route::get('/page/{slug}',            [PageController::class, 'read'])->name('page.read');

// News
Route::get('/news',                   [NewsController::class, 'index'])->name('front.news.index');
Route::get('/news/{slug}',           [NewsController::class, 'show'])->name('front.news.show');

// Events
Route::get('/events',                 [EventController::class, 'index'])->name('front.events.index');
Route::get('/events/{slug}',          [EventController::class, 'show'])->name('front.events.show');

// Gallery
Route::get('/gallery',                [GalleryController::class, 'index'])->name('front.gallery.index');
Route::get('/gallery/{id}',          [GalleryController::class, 'show'])->name('front.gallery.show');

// Admission — both front.admission.* and page.admission.* (legacy alias)
Route::get('/admission',             [AdmissionController::class, 'index'])->name('front.admission.index');
Route::get('/admission',             [AdmissionController::class, 'index'])->name('page.admission');
Route::post('/admission',            [AdmissionController::class, 'submit'])->name('front.admission.submit');
Route::post('/admission',            [AdmissionController::class, 'submit'])->name('page.admission.submit');

// Calendar
Route::get('/calendar',              [CalendarController::class, 'index'])->name('front.calendar.index');
Route::get('/annual-calendar',       [CalendarController::class, 'index'])->name('page.calendar');

// Exam result
Route::get('/exam-result',          [ExamResultController::class, 'index'])->name('front.examresult.index');
Route::get('/examresult',           [ExamResultController::class, 'index'])->name('page.examresult');
Route::post('/exam-result',         [ExamResultController::class, 'lookup'])->name('front.examresult.lookup');

// Online admission list (alias to welcome controller's view)
Route::get('/online-admission',     [PageController::class, 'home'])->name('page.admission.list');
