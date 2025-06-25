<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ServiceTransactionController;
use App\Http\Controllers\POSController;

// Login page
Route::view('/', 'auth.login');

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Branch routes
Route::controller(BranchController::class)->prefix('branches')->name('branches.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/activate', 'activate')->name('activate');
    Route::get('/{id}/view', 'view')->name('view'); // Added branch view route
});

Route::prefix('services')->name('services.')->group(function () {
    Route::get('/', [ServiceTransactionController::class, 'index'])->name('index');
    Route::post('/store', [ServiceTransactionController::class, 'store'])->name('store');
    Route::get('/pos', [ServiceTransactionController::class, 'pos'])->name('pos');   // POS layout form
});

Route::post('/save-transaction', [POSController::class, 'storeTransaction']);

Route::get('/api/refund-transactions/{ss_number}', [POSController::class, 'getRefundableTransactions']);
Route::post('/api/refund-transaction/{transaction_number}', [POSController::class, 'refundWholeTransaction']);
Route::post('/api/refund-items', [POSController::class, 'refundSelectedItems']);