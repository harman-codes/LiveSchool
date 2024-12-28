<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Observers\AnnouncementObserver;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Actions\Action;
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
                ->defaultPaginationPageOption(10)
                ->recordUrl(null)
                ->recordAction(null);
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
        Action::configureUsing(function (Action $action) {
            $action->iconButton();
        });
        DatePicker::configureUsing(function (DatePicker $component) {
            $component->format('d-m-Y');
        });
//        DateTimePicker::configureUsing(function (DateTimePicker $component) {
//            $component
//                ->format('d-m-Y h:i A')
//                ->seconds(false);
//        });
        TimePicker::configureUsing(function (TimePicker $component): void {
            $component
                ->seconds(false);
        });

    }
}
