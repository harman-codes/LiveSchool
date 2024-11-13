<?php

namespace App\Filament\Parent\Pages;

use App\Helpers\SessionYears;
use App\Models\Holiday;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Holidays extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static string $view = 'filament.parent.pages.holidays';
    protected static ?int $navigationSort = 7;

    public function table(Table $table): Table
    {
        return $table
            ->query(Holiday::query()->where('sessionyear', SessionYears::currentSessionYear()))
            ->paginated(false)
            ->columns([
                TextColumn::make('holiday')
                ->label('Date'),
                TextColumn::make('name')
            ]);
    }
}
