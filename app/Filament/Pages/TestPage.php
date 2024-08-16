<?php

namespace App\Filament\Pages;

use App\Models\Schoolclass;
use App\Models\Student;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class TestPage extends Page implements HasForms, HasTable
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.test-page';

    use InteractsWithTable;
    use InteractsWithForms;


    public function getsubjects()
    {
        $schoolclass = Schoolclass::find(1);
        return $schoolclass->subjects;
    }


    public function table(Table $table): Table
    {
        return $table
            ->query(Student::query())
            ->columns([
                TextColumn::make('name'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
