<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // 🔥 FORCE HTTPS DI PRODUCTION (RAILWAY)
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}
