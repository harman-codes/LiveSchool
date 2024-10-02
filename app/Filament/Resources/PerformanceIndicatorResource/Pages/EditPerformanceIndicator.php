<?php

namespace App\Filament\Resources\PerformanceIndicatorResource\Pages;

use App\Filament\Resources\PerformanceIndicatorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPerformanceIndicator extends EditRecord
{
    protected static string $resource = PerformanceIndicatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
