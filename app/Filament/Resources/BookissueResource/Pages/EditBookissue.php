<?php

namespace App\Filament\Resources\BookissueResource\Pages;

use App\Filament\Resources\BookissueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookissue extends EditRecord
{
    protected static string $resource = BookissueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
