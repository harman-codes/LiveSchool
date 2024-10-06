<?php

namespace App\Filament\Parent\Widgets;

use App\Helpers\SessionYears;
use App\Models\Classtest;
use App\Models\Exammark;
use App\Models\PerformanceIndicator;
use App\Models\Student;
use Filament\Widgets\ChartWidget;
use Livewire\Attributes\On;

class ExamTotalMarksChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static ?string $pollingInterval = null;

    protected function getData(): array
    {

        $examsRows = Student::where('id', auth('parent')->user()->id)->withWhereHas('studentdetails', function ($query){
            $query->where('sessionyear', SessionYears::currentSessionYear())->with(['schoolclass']);
        })?->first()?->studentdetails?->first()?->schoolclass?->exams;

        $examNames = [];
        $percentages = [];
        $colors = [];

        foreach ($examsRows as $row) {
            $totalMarks = (int)$row->totalmarks;

            $totalMarksObtained = (int)Exammark::where([
                ['student_id', auth('parent')->user()->id],
                ['exam_id', $row->id]
            ])?->first()?->totalmarksobtained;

//            info($totalMarks);
//            info($row->id);

            $examNames[] = $row->examname;
            $percentage = $totalMarksObtained/$totalMarks*100;
            $percentages[] = round($percentage, 2);

            if(!empty(PerformanceIndicator::all())){
                foreach(PerformanceIndicator::all() as $singleIndicator){
                    if(round($percentage)>=$singleIndicator->min&&round($percentage)<=$singleIndicator->max){
                        $colors[] = $singleIndicator->color;
                        break;
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
