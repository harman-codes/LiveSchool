<?php

namespace App\Filament\Parent\Pages;

use App\Filament\Parent\Widgets\ExamSubjectWiseMarksChart;
use App\Helpers\CurrentUser;
use App\Helpers\Notify;
use App\Helpers\SessionYears;
use App\Models\Exam;
use App\Models\Exammark;
use App\Models\Student;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ExamSubjectWiseMarks extends Page
{


    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static string $view = 'filament.parent.pages.exam-subject-wise-marks';

    protected static ?string $title = 'Subject Wise Marks';

    protected static ?string $navigationGroup = 'Exams';
    protected static ?int $navigationSort = 3;

    /*Custom Properties*/
    public $selectedSubject;
    public $studentdetails;
    public $examObject;
//    public $examMarkObject;

    public function updated($property)
    {
        if($property=='selectedSubject'){
            if(empty($this->selectedSubject)){
                $this->reset('selectedSubject');
            }

            $this->dispatch('subject-selected', examObject: $this->examObject, selectedSubject: $this->selectedSubject)->to(ExamSubjectWiseMarksChart::class);
        }
    }

    public function getAllExamsSubjects()
    {
        $subjectsArray = [];
        if($this?->studentdetails?->schoolclass?->exams){
            foreach($this?->studentdetails?->schoolclass?->exams as $exam){
                foreach($exam->subjects as $subject){
                    $subjectsArray[] = $subject->name;
                }
            }
        }
        return array_unique($subjectsArray);
    }

    public function getMarksForSelectedSubject()
    {
//        $class = $this->studentdetails?->schoolclass->id;
//        return Exam::query()->where('schoolclass_id', $class)->get();

        return $this->examObject;
    }

    public function getSubjectObtainedMarksAsPerExam($examId)
    {
        return Exammark::where([['exam_id', $examId],['student_id', auth('parent')->user()->id]])->first();
    }

    public function mount()
    {
        $studentdetails = CurrentUser::studentdetails();

        /*Exam Object*/
        $class = $studentdetails?->schoolclass->id;
        $this->examObject = Exam::query()->where('schoolclass_id', $class)->get();
        $this->studentdetails = $studentdetails;
    }


}
