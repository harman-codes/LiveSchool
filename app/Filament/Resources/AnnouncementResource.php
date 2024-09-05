<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Filament\Resources\AnnouncementResource\RelationManagers;
use App\Helpers\Notify;
use App\Helpers\SessionYears;
use App\Models\Announcement;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-speaker-wave';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('sessionyear')->label('Session')->default(SessionYears::currentSessionYear())
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                TextInput::make('title')
                    ->label('Title')
                    ->required(),
                Forms\Components\RichEditor::make('description')
                    ->label('Description')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\Select::make('class')
                    ->label('Class')
                    ->relationship('schoolclasses', 'classwithsection', fn($query) => $query->orderBy('id', 'asc'))
                    ->preload()
                    ->multiple()
                    ->required(),
                TextInput::make('author')
                    ->label('Author')
                    ->formatStateUsing(function(){
                        return auth()->user()->name;
                    })
                    ->disabled()
                    ->dehydrated(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('schoolclasses.classwithsection')
                ->badge()
                ->label('Classes'),
//                Tables\Columns\IconColumn::make('is_published')
//                    ->label('Status')
//                    ->boolean(),
                Tables\Columns\ToggleColumn::make('is_published')
                ->label('Approve')
                ->hidden(function(){
                    return auth()->user()->role !== 'admin';
                })
                ->onColor('success')
                ->offColor('danger')
                ->afterStateUpdated(function ($record, $state) {
                    if($state){
                        Notify::success('Approved : '.$record->title);
                    }else{
                        Notify::fail('Disapproved : '.$record->title);
                    }
                }),
                Tables\Columns\TextColumn::make('author'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d-m-Y  H:i A'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('d-m-Y  H:i A')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->color('primary'),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
