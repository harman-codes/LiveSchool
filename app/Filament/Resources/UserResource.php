<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Helpers\Role;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $label = 'Teachers';

    public static function getNavigationBadge(): ?string
    {
        return User::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                /*Section 1*/
                Forms\Components\Section::make()
                    ->columns([
                        'sm' => 1,
                        'md' => 1,
                        'lg' => 3,
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                        Forms\Components\TextInput::make('mobile')
                            ->unique(ignoreRecord: true)
                            ->tel()
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->unique(ignoreRecord: true)
                            ->email()
                            ->required(),
                        Forms\Components\Textarea::make('address')
                            ->nullable()
                            ->columnSpan([
                                'sm' => 1,
                                'md' => 2,
                            ]),
                    ]),

                /*Section 2*/
                Forms\Components\Section::make()
                    ->columns([
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 3,
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('username')
                            ->unique(ignoreRecord: true)
                            ->required(),
                        Forms\Components\TextInput::make('password')->password()
                            ->password()
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create'),
                        Forms\Components\Select::make('role')
                            ->options(Role::$rolesKeyValuePair),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->modifyQueryUsing(function (Builder $query) {
                //Hide Admin record from the table
                return $query->where('id', '!=', 1);
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email'),
//                Tables\Columns\TextColumn::make('role'),
                Tables\Columns\SelectColumn::make('role')
                    ->options(Role::$rolesKeyValuePair)
                    ->visible(Role::isAdminOrPrincipal()),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
                    /*Section 1*/
                    Section::make()
                        ->columns([
                            'md' => 3,
                        ])
                        ->schema([
                            TextEntry::make('name'),
                            TextEntry::make('mobile'),
                            TextEntry::make('email'),
                            TextEntry::make('address')
                                ->columnSpan('full'),
                        ]),

                    /*Section 2*/
                    Section::make()
                        ->schema([
                            TextEntry::make('username'),
                            TextEntry::make('role'),
                        ])->grow(false)
                ])->from('md')->columnSpan('full'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
//            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
