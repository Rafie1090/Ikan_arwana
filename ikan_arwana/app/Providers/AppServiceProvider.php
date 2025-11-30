<?php

namespace App\Providers;

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
        if($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');

            // Auto-migrate for Vercel SQLite Demo
            $dbPath = '/tmp/database.sqlite';
            if (!file_exists($dbPath)) {
                touch($dbPath);
                \Illuminate\Support\Facades\Artisan::call('migrate:fresh --force');
                \Illuminate\Support\Facades\Artisan::call('db:seed --force'); // Optional: if you have seeds
            }
        }
    }
}
