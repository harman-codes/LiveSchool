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
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

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
                Forms\Components\FileUpload::make('pics')
                    ->label('Pictures')
                    ->multiple()
                    ->storeFileNamesIn('original_file_names')
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string)str($file->getClientOriginalName())
                            ->prepend(Carbon::now()->format('d-m-Y_H-i-s') . '_');
                    })
                    ->image()
                    ->imageEditor()
                    ->panelLayout('grid')
                    ->reorderable()
                    ->appendFiles()
                    ->columnSpan('full'),
                Forms\Components\Select::make('class')
                    ->label('Class')
                    ->relationship('schoolclasses', 'classwithsection', fn($query) => $query->orderBy('id', 'asc'))
                    ->preload()
                    ->multiple()
                    ->required(),
                TextInput::make('author')
                    ->label('Author')
                    ->formatStateUsing(function () {
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
//            ->defaultSort('updated_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->limit(20)
                    ->searchable(),
                Tables\Columns\ImageColumn::make('pics')
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText(),
                Tables\Columns\TextColumn::make('schoolclasses.classwithsection')
                    ->badge()
                    ->label('Classes'),
                Tables\Columns\ToggleColumn::make('is_published')
                    ->label('Approve')
                    ->hidden(function () {
                        return auth()->user()->role !== 'admin';
                    })
                    ->onColor('success')
                    ->offColor('danger')
                    ->afterStateUpdated(function ($record, $state) {
                        if ($state) {
                            Notify::success('Approved : ' . $record->title);
                        } else {
                            Notify::fail('Disapproved : ' . $record->title);
                        }
                    }),
                Tables\Columns\TextColumn::make('author'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d-m-Y  H:i A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('d-m-Y  H:i A')
                    ->sortable(),
            ])
            ->filters([
//                Tables\Filters\Filter::make('Latest')
//                    ->query(function (Builder $query) {
//                        return $query->orderByDesc('updated_at');
//                    }),
                Tables\Filters\SelectFilter::make('class')
                    ->label('Classes')
                    ->relationship('schoolclasses', 'classwithsection', modifyQueryUsing: fn(Builder $query) => $query->orderBy('sort', 'asc'))
                    ->multiple()
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('approved')
                    ->query(function (Builder $query) {
                        return $query->where('is_published', 1);
                    }),
                Tables\Filters\Filter::make('notApproved')
                    ->query(function (Builder $query) {
                        return $query->where('is_published', 0);
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
                Section::make()
                    ->schema([
                        TextEntry::make('title'),
                        TextEntry::make('schoolclasses.classwithsection')
                            ->label('Classes')
                            ->badge(),
                    ])->columns(2),

                Section::make()
                    ->schema([
                        TextEntry::make('author'),
                        IconEntry::make('is_published')
                            ->label('Approved')
                            ->boolean()
                    ])->columns(2),

                Section::make()
                    ->schema([
                        TextEntry::make('description')
                            ->html(),
                    ]),
                Section::make()
                    ->schema([
                        ImageEntry::make('pics'),
                    ])
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
