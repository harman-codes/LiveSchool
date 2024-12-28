<?php

namespace App\Filament\Pages;

use App\Helpers\Notify;
use App\Helpers\SessionYears;
use App\Models\Exam;
use App\Models\Exammark;
use App\Models\Schoolclass;
use App\Models\Student;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Exammarks extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.exammarks';

    protected static ?string $title = 'Exam Marks';

    protected static ?string $navigationGroup = 'Exams';
    protected static ?string $navigationLabel = 'Assign Marks';

    protected static ?int $navigationSort = 2;

    /*Custom Properties*/
    public ?string $selectedClass = null;
    public ?string $selectedExam = null;

    public function updatedSelectedClass()
    {
        $this->reset(['selectedExam']);
    }

    public function getAllClasses()
    {
        return Schoolclass::all();
    }

    public function getExams()
    {
        if(!empty($this->selectedClass)){
//            return Exam::where('classname','like', '%'.$this->selectedClass.'%')->get();
            return Exam::query()->withWhereHas('schoolclass', function($query) {
                $query->where('id','=', $this->selectedClass);
            })->get();
        }
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(function(){
                if(empty($this->selectedClass)||empty($this->selectedExam)){
                    return Student::query()->whereNull('id');
                }

                return Student::query()->withWhereHas('studentdetails', function ($query) {
                    $query->where('sessionyear', SessionYears::currentSessionYear())->withWhereHas('schoolclass', function ($query) {
                        $query->where('id','=', $this->selectedClass);
                    });
                });
            })
            ->emptyStateHeading('Select Options')
            ->emptyStateDescription('Please select class and exam to display marks.')
            ->columns([
                TextColumn::make('name')
                    ->description(function($record){
                        $rollno = $record->studentdetails?->first()?->rollno ?? '';
                        $class = $record->studentdetails?->first()?->schoolclass?->classwithsection ?? '';
                        return $class.' | '.$rollno;
                    }),

                TextColumn::make('totalmarks')
                    ->label('Total')
                ->state(function($record) {
                    return $record->studentdetails?->first()?->schoolclass?->exams()->where('id', $this->selectedExam)?->first()?->totalmarks ?? '';
                }),

                TextColumn::make('totalmarksobtained')
                    ->label('Total Obtained')
                    ->state(function($record) {
                        return $record->exammarks()->where('exam_id', $this->selectedExam)?->first()?->totalmarksobtained ?? '';
                    }),
                TextColumn::make('percent')
                ->label('%')
                ->state(function($record) {
                    $totalMarks = $record->studentdetails?->first()?->schoolclass?->exams()->where('id', $this->selectedExam)?->first()?->totalmarks ?? 0;
                    $marksObtained = $record->exammarks()->where('exam_id', $this->selectedExam)?->first()?->totalmarksobtained ?? 0;
                    if($totalMarks > 0){
                        return round(($marksObtained / $totalMarks) * 100, 2);
                    }else{
                        return '';
                    }
                }),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                /*View Marks*/
                Action::make('viewmaxmarks')
                    ->icon('heroicon-o-eye')
                    ->label('')
                    ->infolist(function($record){
                     $marksObtained = $record->exammarks->where('exam_id', $this->selectedExam)?->first()?->marksobtained ?? '';

                         if(!empty($marksObtained)&&is_array($marksObtained)){
                             $arr = array_map(function($key, $val){
                                 return TextEntry::make($key)
                                     ->state(fn() => $val);
                             }, array_keys($marksObtained), array_values($marksObtained));
                             return $arr;
                         }else{
                             Notify::fail('Please assign marks first');
                         }
                    }),
                /*View Marks End*/

                /*Marks*/
                Action::make('maxmarks')
                    ->icon('heroicon-o-pencil-square')
                    ->label('Marks')
                    ->color('warning')
                    ->form(function(Student $record) {
                        if(!empty($this->selectedExam)){
                            $maxmarks = Exam::where('id', $this->selectedExam)?->first()?->maxmarks;

//                            $marksOfStudentFromDB = Exammark::where([
//                                ['sessionyear', SessionYears::currentSessionYear()],
//                                ['student_id', $record->id],
//                                ['exam_id', $this->selectedExam]
//                            ])?->first()?->marksobtained ?? [];

                            $marksOfStudentFromDB = $record->exammarks->where('exam_id', $this->selectedExam)->first()?->marksobtained ?? [];


                            return array_map(function($subject, $maximummarks) use($marksOfStudentFromDB) {
                                return TextInput::make($subject)
                                    ->label(ucwords($subject))
                                    ->default($marksOfStudentFromDB[$subject] ?? 0)
                                    ->helperText('Max Marks: '.$maximummarks);
                            }, array_keys($maxmarks), array_values($maxmarks));
                        }
                    })
                    ->action(function(array $data, Student $record) {
                        if(!empty($this->selectedExam)){

                            $is_recorded = Exammark::updateOrCreate([
                                'sessionyear' => SessionYears::currentSessionYear(),
                                'student_id' => $record->id,
                                'exam_id' => $this->selectedExam
                            ],
                            [
                                'totalmarksobtained' => array_sum(array_values($data)),
                                'marksobtained' => $data
                            ]);

                            if($is_recorded){
                                Notify::success('Marks updated successfully');
                            }
                        }else{
                            Notify::fail('Please select Exam');
                        }
                    }),
                /*Marks End*/
            ])
            ->bulkActions([
                // ...
            ]);
    }

}
