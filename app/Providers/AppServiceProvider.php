<?php

namespace App\Providers;
use App\Models\WorkoutLog;
use App\Observers\WorkoutLogObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

 
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
