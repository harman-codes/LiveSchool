<?php

namespace App\Filament\Parent\Pages;

use App\Models\Classtest;
use App\Models\Student;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ClassTestMarks extends Page  implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.parent.pages.class-test-marks';

    public function table(Table $table): Table
    {
        return $table
            ->query(function(){
                //grab class name from student and filter the results as per that
                $classWithSection = Student::withWhereHas('studentdetails', function ($query){
                    return $query->where('sessionyear', '2024-25')->with(['schoolclass']);
                })?->first()?->studentdetails?->first()?->schoolclass?->classwithsection;

                return Classtest::query()->where('classname', 'like', '%'.$classWithSection.'%');
            })
            ->columns([
                TextColumn::make('classname'),
                TextColumn::make('testname')
                ->label('Test')
                ->description(function($record){
                    return $record->date;
                })
                ->searchable(),
                TextColumn::make('subject')
                ->searchable(),
                TextColumn::make('maxmarks'),
                TextColumn::make('marksobtained')
                ->formatStateUsing(function(Classtest $record){
                    return $record->marksobtained[auth('parent')->user()->id];
                }),
                TextColumn::make('percentage')
                ->label('%')
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
