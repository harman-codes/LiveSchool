<?php

namespace App\Filament\Resources\BookcategoryResource\Pages;

use App\Filament\Resources\BookcategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookcategory extends EditRecord
{
    protected static string $resource = BookcategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
