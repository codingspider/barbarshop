<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap(); 

        $services = Service::where('active', 1)->get();
        $customers = User::where('user_type', 'customer')->get();
        $payments = Payment::whereDate('created_at', Carbon::today())->sum('amount');
        $settings = Setting::first();

        View::share([
            'services' => $services,
            'customers' => $customers,
            'payments' => $payments,
            'siteLogo'   => $settings?->logo ? asset('storage/' . $settings->logo) : null,
            'siteFavicon'=> $settings?->favicon ? asset('storage/' . $settings->favicon) : null,
        ]);
    }
}
