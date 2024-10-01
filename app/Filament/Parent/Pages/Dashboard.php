<?php

namespace App\Filament\Parent\Pages;

use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;



    public function getWidgets(): array
    {
        return [
//            SingleStudentAttendanceChart::class,
        ];
    }

//    public function getColumns(): int | string | array
//    {
//        return [
//            'md' => 2,
//            'xl' => 2,
//        ];
//    }
}
