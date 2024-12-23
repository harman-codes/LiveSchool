<?php

namespace App\Filament\Widgets;

use App\Helpers\School;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class FullSchoolAttendanceChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Attendance Chart';

//    protected static ?string $description = 'Attendance of students';

//    protected int | string | array $columnSpan = [
//        'md' => 1,
//        'xl' => 2,
//    ];

    protected function getData(): array
    {
        $selectedDate = $this->filters['dateforattendance'] ?? null;
        $selectedClass = $this->filters['classforattendance'] ?? 'wholeschool';

//        if(empty($this->filters['classforattendance'])||$this->filters['classforattendance']=='wholeschool'){
//            $selectedClass = 'wholeschool';
//        }else{
//            $selectedClass = $this->filters['classforattendance'];
//        }

        return [
            'datasets' => [
                [
                    'label' => 'Attendance',
                    'data' => [
                        School::attendanceTotalInSchoolOrClassOnDate($selectedDate,$selectedClass,'P'),
                        School::attendanceTotalInSchoolOrClassOnDate($selectedDate,$selectedClass,'A'),
                        School::attendanceTotalInSchoolOrClassOnDate($selectedDate,$selectedClass,'L'),
                        School::attendanceTotalInSchoolOrClassOnDate($selectedDate,$selectedClass,'H'),
                    ],
                    'backgroundColor' => [
                        '#15803D',
                        '#B91C1C',
                        '#FB923C',
                        '#1D4ED8'
                    ],
                    'borderSkipped' => true
                ],
            ],
            'labels' => ['Present','Absent','Leave','Half Day'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
