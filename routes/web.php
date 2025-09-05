<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;



Route::middleware(['SetLocale'])->group(function () {
    Route::get('/', function () {
        return view('user.home');
    });

    Route::get('lang/{locale}', function ($locale) {
        if (in_array($locale, ['en', 'ar', 'fr'])) {
            session(['locale' => $locale]);
            Session::put('locale', $locale);
            App::setLocale($locale);
        }
        $currentLocale = app()->getLocale();
        return redirect()->back();
    })->name('lang.switch');
});

Auth::routes();

