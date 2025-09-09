<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BaberController;
use App\Http\Controllers\Admin\AddonsController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Auth\Admin\LoginController;
use App\Http\Controllers\Admin\ApplicationSettingController;
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
        Route::resource('addons', AddonsController::class);
        Route::resource('users', UserController::class);
        Route::resource('barbers', BaberController::class);

        Route::get('app-management', [ApplicationSettingController::class, 'index'])->name('app-management');

        Route::put('setting-update', [ApplicationSettingController::class, 'update'])->name('settings.update');
        Route::get('filter-tickets', [AdminDashboard::class, 'filterTickets'])->name('filter.tickets');
    });
});