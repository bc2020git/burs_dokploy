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
        view()->composer('*', function ($view) {
            if (auth()->check()) {
                $unreadCount = \App\Models\UserNotification::where('user_email', auth()->user()->email)
                    ->where('is_checked', '0')
                    ->count();
                $view->with('unreadNotificationsCount', $unreadCount);
            }
        });
    }
}
