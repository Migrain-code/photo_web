<?php

namespace App\Providers;

use App\Models\ProjectSubmission;
use App\Observers\ProjectSubmissionObserver;
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
            $view->with('site_logo', $settings->getValue('site_logo'));
        });

        View::composer('partials.footer', function ($view) {
            $settings = app(SettingsService::class);
            $view->with('contact_email', $settings->getValue('contact_email'));
            $view->with('contact_address', $settings->getValue('contact_address'));
            $view->with('instagram_url', $settings->getValue('instagram_url'));
        });

        ProjectSubmission::observe(ProjectSubmissionObserver::class);
    }
}
