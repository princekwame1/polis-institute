<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/about-us', 'about')->name('about');
    Route::get('/courses-and-programmes', 'courses')->name('courses');
    Route::get('/facilitators-and-management', 'facilitators')->name('facilitators');
    Route::get('/admissions-and-registration', 'admissions')->name('admissions');
    Route::get('/corporate-training', 'corporate')->name('corporate');
    Route::get('/student-portal', 'portal')->name('portal');
    Route::get('/news-and-publications', 'news')->name('news');
    Route::get('/news-and-publications/{post}', 'post')->name('news.show');
    Route::get('/contact-us', 'contact')->name('contact');
    Route::get('/faqs', 'faq')->name('faq');
    Route::get('/policies/{policy}', 'policy')
        ->whereIn('policy', ['privacy-policy', 'terms-and-conditions', 'registration-and-refund-policy'])
        ->name('policy');
});

Route::post('/enquiries', [EnquiryController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('enquiries.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [Admin\AuthController::class, 'create'])->name('login');
        Route::post('/login', [Admin\AuthController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [Admin\AuthController::class, 'destroy'])->name('logout');
        Route::get('/', Admin\DashboardController::class)->name('dashboard');

        Route::resource('enquiries', Admin\EnquiryController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::resource('slides', Admin\SlideController::class)->except('show');
        Route::resource('course-areas', Admin\CourseAreaController::class)->except('show');
        Route::resource('faqs', Admin\FaqController::class)->except('show');
        Route::resource('posts', Admin\PostController::class)->except('show');
        Route::resource('facilitators', Admin\FacilitatorController::class)->except('show');

        Route::get('/settings', [Admin\SettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');
        Route::get('/account', [Admin\AccountController::class, 'edit'])->name('account.edit');
        Route::put('/account', [Admin\AccountController::class, 'update'])->name('account.update');
    });
});
