<?php

namespace App\Filament\Parent\Widgets;

use App\Helpers\DT;
use App\Helpers\School;
use App\Helpers\SessionYears;
use App\Models\Attendance;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\Attributes\On;

class SingleStudentAttendanceChart extends ChartWidget
{
//    protected static ?string $heading = 'Attendance';

    public $selectedYear;
    public $selectedMonth;

    #[On('year-selected')]
    public function setYear($selectedyear)
    {
        $this->selectedYear = $selectedyear;
    }

    #[On('month-selected')]
    public function setMonth($selectedmonth)
    {
        $this->selectedMonth = $selectedmonth;
    }

    public function mount(): void
    {
        $this->selectedYear = DT::currentYear();
        $this->selectedMonth = DT::currentMonthName();
        parent::mount();
    }

    public function getHeading(): string
    {
        return ucwords($this->selectedMonth) . ' ' . $this->selectedYear;
    }

    protected function getData(): array
    {
        $selectedMonth = $this->selectedMonth;
        $selectedYear = $this->selectedYear;

        $data = Attendance::where([
            ['sessionyear', SessionYears::currentSessionYear()],
            ['student_id', auth('parent')->user()->id],
            ['year', $selectedYear],
        ])->first();


        $present = [];
        $absent = [];
        $leave = [];
        $halfDay = [];

        if(!empty($data->$selectedMonth)&&is_array($data->$selectedMonth)){
            foreach($data->$selectedMonth as $date => $value){
                if($value=='P'){
                    $present[] = $value;
                }elseif($value=='A'){
                    $absent[] = $value;
                }elseif($value=='L'){
                    $leave[] = $value;
                }elseif($value=='H'){
                    $halfDay[] = $value;
                }
            }
        }



        return [
            'datasets' => [
                [
                    'label' => 'Present',
                    'data' => [
                        count($present),
                    ],
                    'backgroundColor' => [
                        '#15803D',
                    ],
                    'borderSkipped' => true
                ],
                [
                    'label' => 'Absent',
                    'data' => [
                        count($absent),
                    ],
                    'backgroundColor' => [
                        '#B91C1C',
                    ],
                    'borderSkipped' => true
                ],
                [
                    'label' => 'Leave',
                    'data' => [
                        count($leave),
                    ],
                    'backgroundColor' => [
                        '#FB923C',
                    ],
                    'borderSkipped' => true
                ],
                [
                    'label' => 'Half Day',
                    'data' => [
                        count($halfDay),
                    ],
                    'backgroundColor' => [
                        '#1D4ED8'
                    ],
                    'borderSkipped' => true
                ],
            ],
            'labels' => ['Attendance'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
