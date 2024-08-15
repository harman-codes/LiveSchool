<?php

namespace App\Filament\Resources\SchoolclassResource\Pages;

use App\Filament\Resources\SchoolclassResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSchoolclasses extends ListRecords
{
    protected static string $resource = SchoolclassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
