<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


ini_set('max_execution_time', 300); // 5 minute
set_time_limit(300);

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
        //
    }
}
