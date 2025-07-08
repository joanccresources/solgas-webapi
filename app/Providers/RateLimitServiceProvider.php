<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class RateLimitServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        RateLimiter::for('auth', function () {
            return Limit::perMinute(80);
        });

        RateLimiter::for('login', function () {
            return Limit::perMinute(20);
        });

        RateLimiter::for('settingPassword', function () {
            return Limit::perMinute(4);
        });

        RateLimiter::for('web', function () {
            return Limit::perMinute(100);
        });

        RateLimiter::for('webLead', function () {
            return Limit::perMinute(5);
        });

        RateLimiter::for('webBlogAction', function () {
            return Limit::perMinute(10);
        });

        RateLimiter::for('webBlogComment', function () {
            return Limit::perMinute(6);
        });

        RateLimiter::for('cookieConsent', function () {
            return Limit::perMinute(5);
        });
    }
}
