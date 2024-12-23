<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CalendarViewOnlyWidget;
use App\Filament\Widgets\FullSchoolAttendanceChart;
use App\Helpers\DT;
use App\Models\Schoolclass;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('dateforattendance')
                    ->label('Date')
                    ->default(DT::currentDate()),
                Select::make('classforattendance')
                    ->label('Class')
                    ->options(function () {
                        $classes = Schoolclass::query()->orderBy('sort', 'asc')->pluck('classwithsection', 'classwithsection')->toArray();
                        return ['wholeschool' => 'School'] + $classes;
                    })
                    ->default('wholeschool')
            ]);
    }

    public function getWidgets(): array
    {
        return [
            FullSchoolAttendanceChart::class,
            CalendarViewOnlyWidget::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return [
            'md' => 2,
            'xl' => 2,
        ];
    }
}
