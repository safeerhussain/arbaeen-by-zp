<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StatusController;
use App\Models\Booking;
use App\Models\Person;
use Illuminate\Support\Facades\Route;

// Public pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/ar01', [PageController::class, 'ar01'])->name('ar01');
Route::get('/ar02', [PageController::class, 'ar02'])->name('ar02');
Route::get('/payment-info', [PageController::class, 'paymentInfo'])->name('payment-info');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/questions', [PageController::class, 'questions'])->name('questions');

// Registration (Module 4)
Route::get('/register', [BookingController::class, 'create'])->name('register');
Route::post('/register', [BookingController::class, 'store'])->name('register.store');
Route::get('/register/confirmed/{bookingId}', [BookingController::class, 'confirmed'])->name('register.confirmed');

// Booking status check (Module 6)
Route::get('/status', [StatusController::class, 'index'])->name('status');

// API — seat counts (Module 5)
Route::get('/api/counts', function () {
    $capacity = 135;

    $ar01 = Person::whereHas('booking', fn ($q) => $q->where('group', 'AR01')->where('status', 'confirmed'))->count();
    $ar02 = Person::whereHas('booking', fn ($q) => $q->where('group', 'AR02')->where('status', 'confirmed'))->count();

    return response()->json([
        'ar01_confirmed' => $ar01,
        'ar02_confirmed' => $ar02,
        'capacity' => $capacity,
    ]);
})->name('api.counts');

// API — social proof feed (Module 7)
Route::get('/api/feed', [FeedController::class, 'index'])->name('api.feed');

// Admin (Module 9)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/booking/{bookingId}', [AdminController::class, 'show'])->name('booking');
        Route::post('/booking/{bookingId}/status', [AdminController::class, 'updateStatus'])->name('booking.status');
        Route::post('/booking/{bookingId}/payment/{stage}/paid', [AdminController::class, 'markPaymentPaid'])->name('booking.payment.paid');
        Route::post('/person/{personId}/doc-status', [AdminController::class, 'updatePersonDocStatus'])->name('person.doc-status');
        Route::get('/document/{documentId}', [AdminController::class, 'serveDocument'])->name('document.serve');
    });
});
