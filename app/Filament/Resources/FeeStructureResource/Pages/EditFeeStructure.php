<?php

namespace App\Filament\Resources\FeeStructureResource\Pages;

use App\Filament\Resources\FeeStructureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFeeStructure extends EditRecord
{
    protected static string $resource = FeeStructureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
