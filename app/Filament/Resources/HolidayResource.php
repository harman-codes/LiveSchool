<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HolidayResource\Pages;
use App\Filament\Resources\HolidayResource\RelationManagers;
use App\Helpers\SessionYears;
use App\Models\Holiday;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class HolidayResource extends Resource
{
    protected static ?string $model = Holiday::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sessionyear')
                    ->label('Session Year')
                    ->default(SessionYears::currentSessionYear())
                    ->disabled()
                    ->dehydrated(true),
                Forms\Components\Toggle::make('is_singleday')
                    ->label('Single Day ?')
                    ->default(true)
                    ->live()
                    ->required()
                    ->columnSpan('full'),
                Forms\Components\DatePicker::make('date')
                    ->label('Date')
                    ->visible(fn(Forms\Get $get) => $get('is_singleday'))
                    ->required(fn(Forms\Get $get) => $get('is_singleday')),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\DatePicker::make('from')
                            ->label('From')
                            ->required(fn(Forms\Get $get) => !$get('is_singleday')),
                        Forms\Components\DatePicker::make('to')
                            ->label('To')
                            ->required(fn(Forms\Get $get) => !$get('is_singleday')),
                    ])
                    ->columns(2)
                    ->visible(fn(Forms\Get $get) => !$get('is_singleday')),
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->where('sessionyear', SessionYears::currentSessionYear());
            })
            ->recordUrl(null)
            ->recordAction(null)
            ->striped()
            ->reorderable('sort')
            ->defaultSort('sort')
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('holiday')
                ->label('Date'),
                Tables\Columns\TextColumn::make('name')
                ->label('Holiday')
            ])
            ->filters([
                //
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
            'index' => Pages\ListHolidays::route('/'),
//            'create' => Pages\CreateHoliday::route('/create'),
//            'edit' => Pages\EditHoliday::route('/{record}/edit'),
        ];
    }
}
