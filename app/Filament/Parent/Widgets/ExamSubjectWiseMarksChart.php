<?php

namespace App\Filament\Parent\Widgets;

use App\Helpers\Notify;
use App\Helpers\SessionYears;
use App\Models\Exammark;
use App\Models\PerformanceIndicator;
use App\Models\Student;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\Attributes\On;

class ExamSubjectWiseMarksChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static ?string $pollingInterval = null;

    /*Custom Properties*/
    public $examObject;
    public $selectedSubject;

    #[On('subject-selected')]
    public function listenToEvent($examObject, $selectedSubject)
    {
        $this->examObject = $examObject;
        $this->selectedSubject = $selectedSubject;
    }

    public function getHeading(): string|Htmlable|null
    {
        return !empty($this->selectedSubject) ? ucwords($this->selectedSubject) : 'Subject Wise Performance';
    }

    protected function getData(): array
    {

        $examNames = [];
        $percentages = [];
        $colors = [];


        if(!empty($this->examObject)&&!empty($this->selectedSubject)){
            foreach($this->examObject as $row){
                if(array_key_exists($this->selectedSubject, $row['maxmarks'])){
                    $examNames[] = $row['examname'];
                    $maxMarksOfSelectedSubject = (int)$row['maxmarks'][$this->selectedSubject];

                    //get exam marks obtained from Exammark model
                    $marksObtainedArray = Exammark::where([['exam_id', $row['id']],['student_id', auth('parent')->user()->id]])->first()?->marksobtained;

                    if(!empty($marksObtainedArray)&&array_key_exists($this->selectedSubject, $marksObtainedArray)){

                        $percentage = round((int)$marksObtainedArray[$this->selectedSubject]/$maxMarksOfSelectedSubject*100);

                        $percentages[] = $percentage;

                        if(!empty(PerformanceIndicator::all())){
                            foreach(PerformanceIndicator::all() as $singleIndicator){
                                if(round($percentage)>=$singleIndicator->min&&round($percentage)<=$singleIndicator->max){
                                    $colors[] = $singleIndicator->color;
                                    break;
                                }
                            }
                        }
                    }

                }
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'percent',
                    'data' => $percentages,
                    'backgroundColor' => $colors,
                    'borderSkipped' => true
                ],
            ],
            'labels' => $examNames,
        ];
    }


    protected function getType(): string
    {
        return 'bar';
    }
}
