<?php

namespace App\Filament\Resources\TimeTableResource\Pages;

use App\Filament\Resources\TimeTableResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTimeTables extends ListRecords
{
    protected static string $resource = TimeTableResource::class;

    protected static ?string $title = 'Time Table';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
