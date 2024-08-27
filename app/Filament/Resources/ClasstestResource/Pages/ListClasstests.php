<?php

namespace App\Filament\Resources\ClasstestResource\Pages;

use App\Filament\Resources\ClasstestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClasstests extends ListRecords
{
    protected static string $resource = ClasstestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
