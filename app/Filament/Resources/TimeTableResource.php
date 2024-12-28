<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimeTableResource\Pages;
use App\Filament\Resources\TimeTableResource\RelationManagers;
use App\Models\TimeTable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TimeTableResource extends Resource
{
    protected static ?string $model = TimeTable::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'Time Table';

    protected static ?string $navigationLabel = 'Time Table';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->description('Please add slot first')
                    ->columns([
                        'sm' => 1,
                        'md' => 2
                    ])
                    ->schema([
                        Forms\Components\Select::make('schoolclass_id')
                            ->label('Class')
                            ->relationship('schoolclass', 'classwithsection', modifyQueryUsing: fn(Builder $query) => $query->orderBy('sort', 'asc'))
                            ->preload()
                            ->searchable()
                            ->live()
                            ->required(),
                        Forms\Components\Select::make('timetableslot_id')
                            ->label('Slot')
                            ->relationship('timetableslot', 'title', modifyQueryUsing: function (Builder $query, Forms\Get $get) {
                                return $query->where('schoolclass_id', $get('schoolclass_id'));
                            })
                            ->preload()
                            ->searchable()
                            ->disabled(fn(Forms\Get $get): bool => empty($get('schoolclass_id')))
                            ->required(),
                        Forms\Components\TimePicker::make('from')
                            ->required(),
                        Forms\Components\TimePicker::make('to')
                            ->required(),
                        Forms\Components\TextInput::make('subject'),
                        Forms\Components\TextInput::make('remarks'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('schoolclass.classwithsection')
                    ->label('Class'),
                Tables\Columns\TextColumn::make('timetableslot.title')
                    ->label('Day'),
                Tables\Columns\TextColumn::make('from')
                ->sortable(),
                Tables\Columns\TextColumn::make('to'),
                Tables\Columns\TextColumn::make('subject'),
                Tables\Columns\TextColumn::make('remarks')
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('class')
                    ->relationship('schoolclass', 'classwithsection', fn(Builder $query) => $query->orderBy('sort', 'asc'))
                    ->preload()
                    ->searchable()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListTimeTables::route('/'),
//            'create' => Pages\CreateTimeTable::route('/create'),
//            'edit' => Pages\EditTimeTable::route('/{record}/edit'),
        ];
    }
}
