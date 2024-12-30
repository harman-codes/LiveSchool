<?php

namespace App\Filament\Parent\Pages;

use App\Models\Book;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SearchBooks extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static string $view = 'filament.parent.pages.search-books';

    protected static ?string $navigationGroup = 'Library';

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return Book::query();
            })
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('authors.name')
                    ->label('Author')
                    ->searchable()
                    ->badge()
                    ->color('warning'),
                TextColumn::make('bookcategory.name')
                    ->label('Category'),
                TextColumn::make('schoolclasses.classwithsection')
                    ->label('Class')
                    ->badge(),
                TextColumn::make('total'),
                TextColumn::make('issued'),
                TextColumn::make('instock')
                    ->label('In Stock'),
            ])
            ->filters([
                SelectFilter::make('class')
                    ->relationship('schoolclasses', 'classwithsection', modifyQueryUsing: fn($query) => $query->orderBy('sort', 'asc'))
                    ->searchable()
                    ->preload(),
                SelectFilter::make('category')
                    ->relationship('bookcategory', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('author')
                    ->relationship('authors', 'name')
                    ->searchable()
                    ->preload(),
            ]);
    }


}
