<?php

namespace App\Filament\Parent\Pages;

use App\Models\Classtest;
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
            ->query(Classtest::query())
            ->columns([
                TextColumn::make('classname'),
                TextColumn::make('testname')
                ->label('Test')
                ->description(function($record){
                    return $record->date;
                }),
                TextColumn::make('subject'),
                TextColumn::make('maxmarks'),
                TextColumn::make('marksobtained')
                ->formatStateUsing(function(Classtest $record){
                    foreach($record->marksobtained as $studentId => $mo){
                        if($studentId==2){
                            return $mo;
                        }else{
                            return '';
                        }
                    }
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
