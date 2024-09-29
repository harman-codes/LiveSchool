<?php

namespace App\Filament\Parent\Pages;

use App\Helpers\SessionYears;
use App\Models\Exam;
use App\Models\Exammark;
use App\Models\Student;
use Filament\Pages\Page;

class ExamMarks extends Page
{

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.parent.pages.exam-marks';

    /*Custom Properties*/
    public $selectedExam;

    public function getAllExams()
    {
        return Student::withWhereHas('studentdetails', function ($query){
            $query->where('sessionyear', SessionYears::currentSessionYear())->with(['schoolclass']);
        })?->first()?->studentdetails?->first()?->schoolclass?->exams()->get();
    }

    public function getMarksObtained()
    {
        if(!empty($this->selectedExam)){
            return Exammark::where('student_id', auth('parent')->user()->id)->where('exam_id', $this->selectedExam)->first();
        }else{
            return null;
        }
    }

    public function getSubjectsAndMarksFromSelectedExam()
    {
        return Exam::where('id', $this->selectedExam)?->first();
    }

}
