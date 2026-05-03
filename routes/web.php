<?php

use App\Http\Controllers\PageController;
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
Route::get('/register', fn () => view('registration.index', [
    'whatsappMessage' => config('arbaeen.whatsapp_messages.register'),
]))->name('register');

// Booking status check (Module 6)
Route::get('/status', fn () => view('status.index', [
    'whatsappMessage' => config('arbaeen.whatsapp_messages.status'),
]))->name('status');

// API — seat counts (Module 5)
Route::get('/api/counts', fn () => response()->json([
    'ar01_confirmed' => 0,
    'ar02_confirmed' => 0,
]))->name('api.counts');

// Admin (Module 9)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', fn () => view('admin.login'))->name('login');
    Route::get('/', fn () => view('admin.dashboard'))->name('dashboard');
});
