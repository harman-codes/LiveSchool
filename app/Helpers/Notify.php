<?php
namespace App\Helpers;

use Filament\Notifications\Notification;

class Notify{

    public static function success($message){
        Notification::make()
            ->title($message)
            ->success()
            ->color('success')
            ->send();
    }

    public static function fail($message){
        Notification::make()
            ->title($message)
            ->danger()
            ->color('danger')
            ->send();
    }
}
