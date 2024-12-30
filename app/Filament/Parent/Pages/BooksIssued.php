<?php

namespace App\Filament\Parent\Pages;

use App\Helpers\Library;
use App\Models\Bookissue;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BooksIssued extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static string $view = 'filament.parent.pages.books-issued';

    protected static ?string $navigationGroup = 'Library';

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return Bookissue::query()->where('student_id', auth()->user()->id);
            })
            ->columns([
                TextColumn::make('book.title')
                    ->label('Book')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('book.authors.name')
                    ->label('Author')
                    ->badge()
                    ->color('warning')
                    ->searchable(),
                TextColumn::make('book.bookcategory.name')
                    ->label('Category'),
                TextColumn::make('issuedate')
                    ->label('Issue Date'),
                TextColumn::make('returndate')
                    ->label('Return Date'),
                TextColumn::make('returnedon')
                    ->label('Returned On'),
                TextColumn::make('status')
                    ->formatStateUsing(fn($state) => Library::$bookIssueStatus[$state]),
                TextColumn::make('remarks')
                    ->wrap()
            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('book.bookcategory', 'name')
                    ->searchable()
                    ->preload()
            ]);
    }


}
