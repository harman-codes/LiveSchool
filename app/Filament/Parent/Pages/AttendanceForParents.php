<?php

namespace App\Filament\Parent\Pages;

use App\Filament\Parent\Widgets\SingleStudentAttendanceChart;
use App\Helpers\DT;
use Filament\Pages\Page;

class AttendanceForParents extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static string $view = 'filament.parent.pages.attendance-for-parents';

    protected static ?string $navigationLabel = 'Attendance';

    protected static ?string $title = 'Attendance';

    public $selectedYear;
    public $selectedMonth;

    public function updated($property)
    {
        if($property == 'selectedYear'){
            $this->dispatch('year-selected', selectedyear: $this->selectedYear)->to(SingleStudentAttendanceChart::class);
        }

        if($property == 'selectedMonth'){
            $this->dispatch('month-selected', selectedmonth: $this->selectedMonth)->to(SingleStudentAttendanceChart::class);
        }
    }


    public function mount()
    {
        $this->selectedYear = DT::currentYear();
        $this->selectedMonth = DT::currentMonthName();
    }

}
