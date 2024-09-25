<?php

namespace App\Filament\Widgets;

use App\Helpers\School;
use Filament\Widgets\ChartWidget;
use Livewire\Attributes\On;

class SelectedClassAttendanceChart extends ChartWidget
{
    protected static ?string $heading = 'Attendance';

    public $selectedClass;
    public $selectedDate;

    #[On('class-selected')]
    public function setClassValue($selectedclass){
        $this->selectedClass = $selectedclass;
    }

    #[On('date-selected')]
    public function setDateValue($selecteddate){
        $this->selectedDate = $selecteddate;
    }


    protected function getData(): array
    {
        $selectedClass = !empty($this->selectedClass) ? $this->selectedClass : null;
        $selectedDate = !empty($this->selectedDate) ? $this->selectedDate : null;

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
