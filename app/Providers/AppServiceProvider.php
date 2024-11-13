<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Observers\AnnouncementObserver;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
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

        /*Configurations*/
        EditAction::configureUsing(function (EditAction $action) {
            $action->iconButton();
        });
        DeleteAction::configureUsing(function (DeleteAction $action) {
            $action->iconButton();
        });
        ViewAction::configureUsing(function (ViewAction $action) {
            $action->iconButton();
        });

    }
}
