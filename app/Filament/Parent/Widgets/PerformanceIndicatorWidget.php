<?php

namespace App\Filament\Parent\Widgets;

use App\Models\PerformanceIndicator;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PerformanceIndicatorWidget extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                PerformanceIndicator::query()
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('min')
                    ->label('Min (>=)'),
                TextColumn::make('max')
                    ->label('Max (<=)'),
                ColorColumn::make('color'),
                TextColumn::make('remarks')
            ]);
    }
}
