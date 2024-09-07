<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Observers\AnnouncementObserver;
use Illuminate\Database\Eloquent\Model;
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
        Model::unguard();
        Announcement::observe(AnnouncementObserver::class);
    }
}
