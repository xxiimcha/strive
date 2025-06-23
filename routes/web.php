<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BranchController;

// Login page
Route::view('/', 'auth.login');

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Branch routes
Route::controller(BranchController::class)->prefix('branches')->name('branches.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/activate', 'activate')->name('activate');
});
