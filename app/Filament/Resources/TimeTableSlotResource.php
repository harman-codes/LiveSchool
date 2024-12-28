<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimeTableSlotResource\Pages;
use App\Filament\Resources\TimeTableSlotResource\RelationManagers;
use App\Models\TimeTableSlot;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TimeTableSlotResource extends Resource
{
    protected static ?string $model = TimeTableSlot::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?string $navigationGroup = 'Time Table';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\Select::make('schoolclass_id')
                    ->label('Class')
                    ->relationship('schoolclass', 'classwithsection', modifyQueryUsing: fn(Builder $query) => $query->orderBy('sort', 'asc'))
                    ->preload()
                    ->searchable()
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(null)
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Slot'),
                Tables\Columns\TextColumn::make('schoolclass.classwithsection')
                    ->label('Class'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('class')
                    ->relationship('schoolclass', 'classwithsection', fn(Builder $query) => $query->orderBy('sort', 'asc'))
                    ->preload()
                    ->searchable()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTimeTableSlots::route('/'),
//            'create' => Pages\CreateTimeTableSlot::route('/create'),
//            'edit' => Pages\EditTimeTableSlot::route('/{record}/edit'),
        ];
    }
}
