<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DriverResource\Pages;
use App\Filament\Resources\DriverResource\RelationManagers;
use App\Models\Driver;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('mobile')
                    ->tel()
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required(),
                Forms\Components\Textarea::make('address'),
                Forms\Components\TextInput::make('van')
                    ->label('Vehicle No')
                    ->unique(ignoreRecord: true)
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrated(fn($state) => filled($state))
                    ->required(fn(string $context): bool => $context === 'create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('van')
                    ->label('Vehicle No')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_switchon')
                    ->label('Location Status')
                    ->boolean()
            ])
            ->filters([
                Tables\Filters\Filter::make('Location On')
                    ->query(function (Builder $query, array $data) {
                        return $query->where('is_switchon', 1);
                    }),
                Tables\Filters\Filter::make('Location Off')
                    ->query(function (Builder $query, array $data) {
                        return $query->where('is_switchon', 0);
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Split::make([
                    Section::make()
                        ->columns([
                            'sm' => 1,
                            'md' => 3,
                        ])
                        ->schema([
                            TextEntry::make('name'),
                            TextEntry::make('mobile'),
                            TextEntry::make('email'),
                            TextEntry::make('address')->columnSpan('full'),
                        ]),

                    Section::make()
                        ->schema([
                            TextEntry::make('van')->label('Vehicle No'),
                            IconEntry::make('is_switchon')
                                ->label('Location Status')
                                ->boolean(),
                        ])->grow(false)
                ])->columnSpan('full')->from('lg')
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
            'index' => Pages\ListDrivers::route('/'),
            'create' => Pages\CreateDriver::route('/create'),
            'edit' => Pages\EditDriver::route('/{record}/edit'),
        ];
    }
}
