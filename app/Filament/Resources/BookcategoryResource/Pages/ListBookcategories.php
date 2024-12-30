<?php

namespace App\Filament\Resources\BookcategoryResource\Pages;

use App\Filament\Resources\BookcategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookcategories extends ListRecords
{
    protected static string $resource = BookcategoryResource::class;

    protected static ?string $title = 'Book Category';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Create Category'),
        ];
    }
}
