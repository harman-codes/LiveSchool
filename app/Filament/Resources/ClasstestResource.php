<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClasstestResource\Pages;
use App\Filament\Resources\ClasstestResource\RelationManagers;
use App\Helpers\Notify;
use App\Helpers\SessionYears;
use App\Models\Classtest;
use App\Models\Schoolclass;
use App\Models\Subject;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ClasstestResource extends Resource
{
    protected static ?string $model = Classtest::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    protected static ?string $navigationGroup = 'Class Tests';
    protected static ?string $navigationLabel = 'Create Test';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('sessionyear')->label('Session')->default(SessionYears::currentSessionYear())
                ->disabled()
                ->dehydrated()
                ->required(),
                DatePicker::make('date')->label('Test Date')->required(),
                Select::make('classname')
                    ->options(function(){
                        return Schoolclass::all()->pluck('classwithsection', 'classwithsection');
                    })
                    ->label('Class')
                    ->required(),
                Select::make('subject')
                    ->options(function(){
                        return Subject::all()->pluck('name', 'name');
                    }),
                TextInput::make('testname')->label('Test Name')->placeholder('For Ex: English Test')->required(),
                TextInput::make('maxmarks')->integer()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')->date('d-m-Y')->label('Test Date'),
                Tables\Columns\TextColumn::make('sessionyear')->label('Session'),
                Tables\Columns\TextColumn::make('classname')->label('Class'),
                Tables\Columns\TextColumn::make('subject')->badge(),
                Tables\Columns\TextColumn::make('testname')->label('Test Name')->searchable(),
                Tables\Columns\TextInputColumn::make('maxmarks')->label('Max Marks')
                    ->afterStateUpdated(function ($record, $state) {
                        Notify::success($record->testname.' : Marks Updated');
                    }),
            ])
            ->filters([
                Tables\Filters\Filter::make('testdate')
                    ->form([
//                        DatePicker::make('testdate')->label('Test Date'),
                    Select::make('testdate')
                        ->options(function(){
                            return Classtest::all()->pluck('date', 'date');
                        })
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                                $data['testdate'],
                                function (Builder $query) use($data){
                                    return $query->where('date', '=', $data['testdate']);
                                }
                            );
                    })
            ], layout: Tables\Enums\FiltersLayout::AboveContent)
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
            'index' => Pages\ListClasstests::route('/'),
            'create' => Pages\CreateClasstest::route('/create'),
            'edit' => Pages\EditClasstest::route('/{record}/edit'),
        ];
    }
}
