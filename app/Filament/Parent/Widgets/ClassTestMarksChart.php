<?php

namespace App\Filament\Parent\Widgets;

use App\Helpers\SessionYears;
use App\Models\Classtest;
use App\Models\PerformanceIndicator;
use App\Models\Student;
use Filament\Widgets\ChartWidget;

class ClassTestMarksChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {

        $classWithSection = Student::where('id', auth('parent')->user()->id)->withWhereHas('studentdetails', function ($query){
            return $query->where('sessionyear', SessionYears::currentSessionYear())->with(['schoolclass']);
        })?->first()?->studentdetails?->first()?->schoolclass?->classwithsection;

        $matchingRows = Classtest::query()->where('classname', 'like', '%'.$classWithSection.'%')->get();

        $performanceColors = PerformanceIndicator::all();

        info($performanceColors);

        $testNames = [];
        $percentages = [];
        $colors = [];

        foreach ($matchingRows as $row) {
//            $marksPercent[$key] = $value->marksobtained[auth('parent')->user()->id] ?? 0;
//            info($row->maxmarks);
            $testNames[] = $row->testname;
            $percentages[] = $row->percentage;

            if(!empty(PerformanceIndicator::all())){
                foreach(PerformanceIndicator::all() as $singleIndicator){
                    if($row->percentage>=$singleIndicator->min&&$row->percentage<=$singleIndicator->max){
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
            'labels' => $testNames,
        ];
    }



    protected function getType(): string
    {
        return 'bar';
    }
}
