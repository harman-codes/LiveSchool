<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Library';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required(),
                        Forms\Components\Select::make('bookcategory_id')
                            ->label('Book Category')
                            ->relationship('bookcategory', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('Category Name')
                                    ->unique()
                                    ->required(),
                                Forms\Components\Textarea::make('description')
                                    ->label('Description')
                            ]),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('schoolclass')
                            ->label('Class')
                            ->relationship('schoolclasses', 'classwithsection', modifyQueryUsing: fn(Builder $query) => $query->orderBy('sort', 'asc'))
                            ->multiple()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('author')
                            ->relationship('authors', 'name', modifyQueryUsing: fn(Builder $query) => $query->orderBy('name', 'asc'))
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('Author Name')
                                    ->unique()
                                    ->required(),
                            ]),
                        Forms\Components\TextInput::make('publisher'),
                        Forms\Components\TextInput::make('bookno')
                            ->label('Book No'),
                        Forms\Components\TextInput::make('isbn')
                            ->label('ISBN'),
                        Forms\Components\TextInput::make('year'),
                    ]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('total'),
                        Forms\Components\TextInput::make('issued'),
                        Forms\Components\TextInput::make('instock')
                            ->label('In Stock'),
                    ]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Textarea::make('remarks')
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(null)
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bookcategory.name')
                    ->label('Category')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('authors.name')
                    ->label('Author')
                    ->badge()
                    ->color('warning')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('schoolclasses.classwithsection')
                    ->label('Class')
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('publisher')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('bookno')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('isbn')
                    ->label('ISBN')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('year')
                    ->toggleable(),
                Tables\Columns\TextInputColumn::make('total')
                    ->toggleable(),
                Tables\Columns\TextInputColumn::make('issued')
                    ->toggleable(),
                Tables\Columns\TextInputColumn::make('instock')
                    ->label('In Stock')
                    ->toggleable(),
                Tables\Columns\TextInputColumn::make('remarks')
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('class')
                    ->relationship('schoolclasses', 'classwithsection',modifyQueryUsing: fn(Builder $query) => $query->orderBy('sort', 'asc'))
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
                        TextEntry::make('bookcategory.name')
                            ->label('Book Category'),
                        TextEntry::make('description')
                            ->columnSpanFull(),
                    ]),
                Section::make()
                    ->schema([
                        TextEntry::make('schoolclasses.classwithsection')
                            ->label('Class')
                            ->badge(),
                        TextEntry::make('authors.name')
                            ->label('Author')
                            ->badge()
                            ->color('warning'),
                        TextEntry::make('publisher'),
                        TextEntry::make('bookno')
                            ->label('Book No'),
                        TextEntry::make('isbn')
                            ->label('ISBN'),
                        TextEntry::make('year'),
                    ]),
                Section::make()
                    ->schema([
                        TextEntry::make('total'),
                        TextEntry::make('issued'),
                        TextEntry::make('instock')
                            ->label('In Stock'),
                    ]),
                Section::make()
                    ->schema([
                        TextEntry::make('remarks')
                            ->columnSpanFull(),
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
            'index' => Pages\ListBooks::route('/'),
//            'create' => Pages\CreateBook::route('/create'),
//            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
