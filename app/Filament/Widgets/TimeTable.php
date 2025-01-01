<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class TimeTable extends BaseWidget
{

    public function table(Table $table): Table
    {
        return $table
            ->paginated([4])
            ->query(\App\Models\TimeTable::query())
            ->columns([
                Tables\Columns\TextColumn::make('schoolclass.classwithsection')
                ->label('Class'),
                Tables\Columns\TextColumn::make('timetableslot.title')
                ->label('Slot'),
                Tables\Columns\TextColumn::make('from')
                ->sortable(),
                Tables\Columns\TextColumn::make('to'),
                Tables\Columns\TextColumn::make('subject'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('class')
                    ->relationship('schoolclass', 'classwithsection', fn(Builder $query) => $query->orderBy('sort', 'asc'))
                ->searchable()
                ->preload()
                ->default(1)
            ]);
    }
}
