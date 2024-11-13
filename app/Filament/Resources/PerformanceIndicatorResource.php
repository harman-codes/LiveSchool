<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PerformanceIndicatorResource\Pages;
use App\Filament\Resources\PerformanceIndicatorResource\RelationManagers;
use App\Models\PerformanceIndicator;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PerformanceIndicatorResource extends Resource
{
    protected static ?string $model = PerformanceIndicator::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-up';

    protected static ?string $navigationLabel = 'Indicator';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('min')
                ->integer()
                ->prefix('Greater than equals')
                ->required()
                ->label('Min Value'),
                Forms\Components\TextInput::make('max')
                ->integer()
                ->prefix('Less than equals')
                ->required()
                ->label('Max Value'),
                Forms\Components\TextInput::make('remarks')
                ->required(),
                Forms\Components\ColorPicker::make('color')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('min')
                ->label('Min (>=)'),
                Tables\Columns\TextColumn::make('max')
                ->label('Max (<=)'),
                Tables\Columns\ColorColumn::make('color'),
                Tables\Columns\TextColumn::make('remarks')
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
            'index' => Pages\ListPerformanceIndicators::route('/'),
//            'create' => Pages\CreatePerformanceIndicator::route('/create'),
//            'edit' => Pages\EditPerformanceIndicator::route('/{record}/edit'),
        ];
    }
}
