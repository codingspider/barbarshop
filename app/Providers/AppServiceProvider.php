<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Service;
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

        View::share([
            'services' => $services,
            'customers' => $customers,
        ]);
    }
}
