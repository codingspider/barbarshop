<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Auth\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Login routes
    Route::get('/login', [LoginController::class, 'showAdminLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'adminLogin']);

    // Protected routes (only accessible by admins)
    Route::middleware(['isAdmin', 'SetLocale'])->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        Route::resource('currencies', CurrencyController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('users', UserController::class);
    });
});