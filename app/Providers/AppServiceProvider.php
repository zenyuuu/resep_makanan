<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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
        // Ensure route-model binding for 'resep' only matches numeric IDs so '/reseps/create' isn't captured as {resep}
        Route::pattern('resep', '[0-9]+');
    }
}
