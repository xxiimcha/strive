<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Login page
Route::get('/', function () {
    return view('auth.login');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');