<?php

namespace App\Filament\Parent\Pages;

use App\Helpers\CurrentUser;
use App\Helpers\SessionYears;
use App\Models\Student;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Classmates extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static string $view = 'filament.parent.pages.classmates';

    protected static ?string $title = 'Classmates';

    protected static ?int $navigationSort = 9;

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return Student::query()->withWhereHas('studentdetails', function ($query) {
                    return $query->where('sessionyear', SessionYears::currentSessionYear())->withWhereHas('schoolclass', function ($query) {
                        return $query->where('id', CurrentUser::classId());
                    });
                });
            })
            ->defaultSort('studentdetails.rollno')
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('studentdetails.rollno')
                    ->label('Roll No')
                    ->sortable()
                    ->searchable()
                    ->alignCenter(),
            ]);
    }


}
