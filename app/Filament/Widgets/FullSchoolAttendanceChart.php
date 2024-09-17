<?php

namespace App\Filament\Widgets;

use App\Helpers\School;
use Filament\Widgets\ChartWidget;

class FullSchoolAttendanceChart extends ChartWidget
{
    protected static ?string $heading = 'Attendance Chart';

    protected static ?string $description = 'Attendance of all students in the school';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Attendance',
                    'data' => [
                        School::attendanceTotalInSchoolToday('P'),
                        School::attendanceTotalInSchoolToday('A'),
                        School::attendanceTotalInSchoolToday('L'),
                        School::attendanceTotalInSchoolToday('H'),
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
