<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeeStructureResource\Pages;
use App\Filament\Resources\FeeStructureResource\RelationManagers;
use App\Helpers\DT;
use App\Helpers\SessionYears;
use App\Models\FeeStructure;
use App\Models\Schoolclass;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FeeStructureResource extends Resource
{
    protected static ?string $model = FeeStructure::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sessionyear')
                    ->label('Session Year')
                    ->default(SessionYears::currentSessionYear())
                    ->disabled()
                    ->dehydrated(true),
                Forms\Components\TextInput::make('title')
                ->placeholder('Any relevant title')
                ->required(),
//                Forms\Components\Select::make('sessionyear')
//                ->label('Session Year')
//                ->options(function(){
//                    return SessionYears::years();
//                })
//                ->live()
//                ->required(),
                Forms\Components\TextInput::make('amount')
                ->required(),
                Forms\Components\DatePicker::make('from')
                    ->required()
                    ->default(DT::currentDate()),
                Forms\Components\DatePicker::make('to')
                    ->required()
                    ->default(DT::currentDate()),
                Forms\Components\DatePicker::make('lastdate')
                    ->label('Last Date')
                    ->required()
                    ->default(DT::currentDate()),
                Forms\Components\Select::make('class')
                    ->relationship('schoolclasses', 'classwithsection', function(Builder $query) {
                        $query->orderBy('sort', 'asc');
                    })
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->pivotData(function(Forms\Get $get){
                        return [
                            'sessionyear' => $get('sessionyear'),
                        ];
                    })
                    ->label('Class')
                    ->required(),
                Forms\Components\Textarea::make('remarks')
                ->label('Remarks (Optional)')
                ->placeholder('Short Note')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->columns([
                Tables\Columns\TextColumn::make('sessionyear')
                ->label('Session Year'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('amount'),
                Tables\Columns\TextColumn::make('from'),
                Tables\Columns\TextColumn::make('to'),
                Tables\Columns\TextColumn::make('lastdate')
                ->label('Last Date'),
                Tables\Columns\TextColumn::make('schoolclasses.classwithsection')
                    ->badge()
                    ->label('Class'),
                Tables\Columns\TextColumn::make('remarks')
                ->wrap()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('class')
                    ->relationship('schoolclasses', 'classwithsection', function(Builder $query) {
                        $query->orderBy('sort', 'asc');
                    })
                    ->options(function(){
                        return Schoolclass::all()->pluck('classwithsection', 'id');
                    })
                    ->preload()
                    ->searchable()
                    ->placeholder('All Classes')
                    ->default(null),
            ], layout: Tables\Enums\FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-m-pencil-square')
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                ->icon('heroicon-o-trash')
                ->iconButton(),
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
            'index' => Pages\ListFeeStructures::route('/'),
            'create' => Pages\CreateFeeStructure::route('/create'),
            'edit' => Pages\EditFeeStructure::route('/{record}/edit'),
        ];
    }
}
