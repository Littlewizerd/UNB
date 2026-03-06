<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Message;

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
        View::composer('layouts.navigation', function ($view) {
            $unreadMessageCount = 0;
            if (Auth::check()) {
                $unreadMessageCount = Message::where('recipient_id', Auth::id())
                    ->whereNull('recipient_deleted_at')
                    ->where('is_read', false)
                    ->count();
            }
            $view->with('unreadMessageCount', $unreadMessageCount);
        });
    }
}
