<?php

namespace App\Filament\Resources\SchoolclassResource\Pages;

use App\Filament\Resources\SchoolclassResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSchoolclass extends EditRecord
{
    protected static string $resource = SchoolclassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
