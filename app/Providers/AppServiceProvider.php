<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;

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
        if (config('app.force_https') || $this->app->environment('production')) {
            URL::forceScheme('https');
        }
        if (env('RUN_STORAGE_LINK') && !is_link(public_path('storage'))) {
            Artisan::call('storage:link');
        }
    }
}
