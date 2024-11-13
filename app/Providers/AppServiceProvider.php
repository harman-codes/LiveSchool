<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Observers\AnnouncementObserver;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;
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
        RichEditor::configureUsing(function (RichEditor $component): void {
            $component->toolbarButtons([
                'bold',
                'italic',
                'underline',
                'redo',
                'undo',
                'bulletList',
                'orderedList',
                'strike',
            ]);
        });

        Table::configureUsing(function (Table $table): void {
            $table
                ->defaultPaginationPageOption(10);
        });

        TimePicker::configureUsing(function (TimePicker $component): void {
            $component
                ->seconds(false);
        });
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
