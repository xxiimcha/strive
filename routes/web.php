<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Login page
Route::get('/', function () {
    return view('auth.login');
});

// Dashboard route (requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
