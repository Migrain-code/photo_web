<?php

namespace App\Providers;

use App\Services\SettingsService;
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
        View::composer('partials.nav', function ($view) {
            $settings = app(SettingsService::class);
            $view->with('site_logo', $settings->getValue('site_logo'));
            $view->with('instagram_url', $settings->getValue('instagram_url'));
        });

        View::composer('layouts.app', function ($view) {
            $settings = app(SettingsService::class);
            $view->with('site_favicon', $settings->getValue('site_favicon'));
        });
    }
}
