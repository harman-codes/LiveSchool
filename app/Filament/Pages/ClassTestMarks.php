<?php

namespace App\Filament\Pages;

use App\Helpers\SessionYears;
use App\Models\Classtest;
use App\Models\Schoolclass;
use App\Models\Student;
use App\Tables\Columns\ClassTestMarksObtainedColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ClassTestMarks extends Page implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.class-test-marks';
    protected static ?string $navigationGroup = 'Class Tests';
    protected static ?string $navigationLabel = 'Assign Marks';

    protected static ?int $navigationSort = 2;

    /*Custom Properties*/
    public ?string $selectedClass = null;
    public ?string $selectedClassTest = null;
    public ?string $maxmarks = null;



    /*Custom Methods*/
    public function updatedSelectedClass()
    {
        $this->reset(['selectedClassTest']);
    }

    public function updatedSelectedClassTest()
    {
        $this->maxmarks = Classtest::find($this->selectedClassTest)?->maxmarks;
    }

    public function getAllClasses()
    {
        return Schoolclass::all();
    }

    public function getClassTests()
    {
        if(!empty($this->selectedClass)){
            return Classtest::where('classname','like', '%'.$this->selectedClass.'%')->get();
        }
    }


    /*Table Method*/
    public function table(Table $table): Table
    {
        return $table
            ->query(function(){
                return Student::query()->withWhereHas('studentdetails', function ($query) {
                    $query->where('sessionyear', SessionYears::currentSessionYear())->withWhereHas('schoolclass', function ($query) {
                        if(!empty($this->selectedClass)){
                            $query->where('classwithsection','like', '%'.$this->selectedClass.'%');
                        }else{
                            //return all classes
                            $query->where('classwithsection','like', '%');
                        }
                    });
                });
            })
            ->columns([
                TextColumn::make('name')
                    ->description(function($record){
                        $rollno = $record->studentdetails?->first()?->rollno ?? '';
                        $class = $record->studentdetails?->first()?->schoolclass?->classwithsection ?? '';
                        return $class.' | '.$rollno;
                    }),
                TextColumn::make('maxmarks')
                    ->label('Max Marks')
                    ->state(function(){
                        if(!empty($this->selectedClass)&&!empty($this->selectedClassTest)&&!empty($this->maxmarks)){
                            return $this->maxmarks;
                        }else{
                            return '';
                        }
                    }),
//                TextColumn::make('marksobtained')
//                ->label('Marks Obtained')
//                ->state(function($record){
//                    if(!empty($this->selectedClass)&&!empty($this->selectedClassTest)&&!empty($this->maxmarks)){
//                        return Classtest::find($this->selectedClassTest)?->marksobtained[$record->id] ?? '';
//                    }else{
//                        return '';
//                    }
//                }),
                ClassTestMarksObtainedColumn::make('setmarks')
                ->label('Marks Obtained'),
            ])
            ->filters([
                // ...
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
