<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        view()->composer(
            [
                '*',
            ],
            function ($view) {
                $view->with('user', auth()->user());
            }
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        if (str_contains(config('app.url'), 'https')) {
            URL::forceScheme('https');
        }
    }
}
