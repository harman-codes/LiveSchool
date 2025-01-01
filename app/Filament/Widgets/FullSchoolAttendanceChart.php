<?php

namespace App\Filament\Widgets;

use App\Helpers\School;
use App\Models\Schoolclass;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class FullSchoolAttendanceChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Today\'s Attendance';

//    protected static ?string $description = 'Attendance of students';

    protected static ?string $maxHeight = '300px';

    protected function getFilters(): ?array
    {
        return ['wholeschool' => 'School']+Schoolclass::query()->orderBy('sort', 'asc')->pluck('classwithsection', 'classwithsection')->toArray();
    }

    protected function getData(): array
    {
//        $selectedDate = $this->filters['dateforattendance'] ?? null;
//        $selectedClass = $this->filters['classforattendance'] ?? 'wholeschool';

        $selectedClass = $this->filter ?? 'wholeschool';

        $selectedDate = now()->format('d-m-Y');
//        $selectedClass = 'wholeschool';

        return [
            'datasets' => [
                [
                    'label' => 'Attendance',
                    'data' => [
                        School::attendanceTotalInSchoolOrClassOnDate($selectedDate, $selectedClass, 'P'),
                        School::attendanceTotalInSchoolOrClassOnDate($selectedDate, $selectedClass, 'A'),
                        School::attendanceTotalInSchoolOrClassOnDate($selectedDate, $selectedClass, 'L'),
                        School::attendanceTotalInSchoolOrClassOnDate($selectedDate, $selectedClass, 'H'),
                    ],
                    'backgroundColor' => [
                        '#15803D',
                        '#B91C1C',
                        '#FB923C',
                        '#1D4ED8'
                    ],
                    'borderSkipped' => true,
                    'animation' => [
                        'duration' => 1500
                    ],
                ],
            ],
            'labels' => ['Present', 'Absent', 'Leave', 'Half Day'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
