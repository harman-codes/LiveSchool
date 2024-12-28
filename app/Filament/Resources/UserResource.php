<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Helpers\Role;
use App\Models\User;
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

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $label = 'Users';
    protected static ?string $navigationGroup = 'Users';
    protected static ?int $navigationSort = 1;

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
                            ->options(Role::$rolesKeyValuePair)
                        ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
//            ->modifyQueryUsing(function (Builder $query) {
//                //Hide Admin record from the table
//                return $query->where('id', '!=', 1);
//            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\SelectColumn::make('role')
                    ->options(Role::$rolesKeyValuePair)
                    ->visible(Role::isAdmin())
                    ->disabled(fn($record) => $record->id === 1),
                Tables\Columns\TextColumn::make('showrole')
                    ->label('Role')
                    ->getStateUsing(fn($record) => ucwords($record->role))
                    ->visible(!Role::isAdmin()),
                Tables\Columns\ToggleColumn::make('is_admin')
                    ->label('Admin')
                    ->disabled(fn($record) => $record->id === 1)
                    ->visible(fn($record) => Role::isAdmin())
                    ->onColor('success')
                    ->offColor('danger'),
                Tables\Columns\IconColumn::make('is_admin_icon')
                    ->boolean()
                    ->label('Admin')
                    ->visible(!Role::isAdmin()),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active')
                    ->disabled(fn($record) => $record->id === 1)
                    ->visible(fn($record) => Role::isAdminOrManagementOrPrincipalOrManager())
                    ->onColor('success')
                    ->offColor('danger'),
                Tables\Columns\IconColumn::make('is_active_icon')
                    ->boolean()
                    ->label('Active')
                    ->visible(!Role::isAdminOrManagementOrPrincipalOrManager()),
                Tables\Columns\ToggleColumn::make('is_available')
                    ->label('Available')
                    ->disabled(fn($record) => $record->id === 1)
                    ->visible(fn($record) => Role::isAdminOrManagementOrPrincipalOrManager())
                    ->onColor('success')
                    ->offColor('danger'),
                Tables\Columns\IconColumn::make('is_available_icon')
                    ->boolean()
                    ->label('Available')
                    ->visible(!Role::isAdminOrManagementOrPrincipalOrManager()),
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
                        ])->grow(false),
                ])->from('md')->columnSpan('full'),

                /*Section Bottom*/
                Section::make()
                    ->schema([
                        IconEntry::make('is_admin')
                            ->label('Admin')
                            ->boolean(),
                        IconEntry::make('is_active')
                            ->label('Active')
                            ->boolean(),
                        IconEntry::make('is_available')
                            ->label('Available')
                            ->boolean(),
                    ])->columns(3)
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
//            'create' => Pages\CreateUser::route('/create'),
//            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
