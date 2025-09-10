<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;


Route::middleware(['SetLocale', 'isUser'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

Route::get('lang', [LanguageController::class, 'change'])->name("change.lang");

Route::get('/clear-all-cache', function () {
    // Clear application cache
    \Artisan::call('cache:clear');

    // Clear config cache
    \Artisan::call('config:clear');

    // Clear route cache
    \Artisan::call('route:clear');

    // Clear compiled views
    \Artisan::call('view:clear');

    // Optionally optimize again
    \Artisan::call('optimize');

    return "✅ All caches cleared successfully!";
})->name('clear.cache');


Auth::routes();

