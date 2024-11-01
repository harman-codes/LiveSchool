<?php

namespace App\Filament\Parent\Pages;

use App\Filament\Parent\Widgets\ExamTotalMarksChart;
use App\Helpers\SessionYears;
use App\Models\Exammark;
use App\Models\Student;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class ExamTotalMarks extends Page implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.parent.pages.exam-total-marks';

    protected static ?string $title = 'Total Marks';
    protected static ?string $navigationGroup = 'Exams';
    protected static ?int $navigationSort = 2;


    public function table(Table $table): Table
    {
        return $table
            ->query(function(){
                $exams = Student::where('id', auth('parent')->user()->id)->withWhereHas('studentdetails', function ($query){
                    $query->where('sessionyear', SessionYears::currentSessionYear())->with(['schoolclass']);
                })?->first()?->studentdetails?->first()?->schoolclass?->exams();
                if(!empty($exams)){
                    return $exams;
                }else{
                    return Student::where('id', auth('parent')->user()->id);
                }
            })
            ->columns([
                TextColumn::make('examname')
                ->label('Exam Name'),
                TextColumn::make('totalmarks')
                ->label('Total Marks'),
                TextColumn::make('marksobtained')
                ->label('Marks Obtained')
                ->getStateUsing(function($record){
//                    return $record->id;
                    return Exammark::where('student_id', auth('parent')->user()->id)->where('exam_id', $record->id)?->first()?->totalmarksobtained ?? '';
                }),
                TextColumn::make('percent')
                    ->label('%')
                    ->getStateUsing(function($record){
                        $totalMarks = (int)$record->totalmarks;
                        $marksObtained = (int)Exammark::where('student_id', auth('parent')->user()->id)->where('exam_id', $record->id)?->first()?->totalmarksobtained;
                        if(!empty($totalMarks)){
                            return round($marksObtained/$totalMarks*100, 2);
                        }else{
                            return '';
                        }
                    }),
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
