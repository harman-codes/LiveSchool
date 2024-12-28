<?php

namespace App\Filament\Resources\TimeTableSlotResource\Pages;

use App\Filament\Resources\TimeTableSlotResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTimeTableSlot extends EditRecord
{
    protected static string $resource = TimeTableSlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
