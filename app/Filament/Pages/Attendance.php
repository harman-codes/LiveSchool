<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\SelectedClassAttendanceChart;
use App\Helpers\DT;
use App\Helpers\SessionYears;
use App\Models\Schoolclass;
use App\Models\Student;
use App\Tables\Columns\AttendanceColumn;
use Carbon\Carbon;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Attendance extends Page implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static string $view = 'filament.pages.attendance';
//    protected static ?string $navigationGroup = 'Class Tests';
    protected static ?string $navigationLabel = 'Attendance';

    /*Custom Properties*/
    public ?string $selectedClass = null;
    public ?string $selectedDate = null;

    public function updated($property)
    {
        if ($property == 'selectedClass') {
            $this->dispatch('class-selected', selectedclass: $this->selectedClass)->to(SelectedClassAttendanceChart::class);
        }

        if ($property == 'selectedDate') {
            $this->dispatch('date-selected', selecteddate: $this->selectedDate)->to(SelectedClassAttendanceChart::class);
        }
    }

    public function mount()
    {
        $this->selectedDate = Carbon::now()->format('Y-m-d');
    }

    public function getAllClasses()
    {
        return Schoolclass::all();
    }

    public function table(Table $table): Table
    {
        return $table
            ->striped()
            ->emptyStateHeading('Select Options')
            ->emptyStateDescription('Please select class and date to display the attendance.')
            ->query(function () {
                if (empty($this->selectedClass) || empty($this->selectedDate)) {
                    return Student::query()->whereNull('id');
                }
                return Student::query()->withWhereHas('studentdetails', function ($query) {
                    $query->where('sessionyear', SessionYears::currentSessionYear())->withWhereHas('schoolclass', function ($query) {
                        $query->where('classwithsection', 'like', '%' . $this->selectedClass . '%');
                    });
                });
            })
            ->defaultSort('rollno', 'asc')
            ->columns([
                TextColumn::make('name')
                    ->description(function ($record) {
//                        $rollno = $record->studentdetails?->first()?->rollno ?? '';
                        $class = $record->studentdetails?->first()?->schoolclass?->classwithsection ?? '';
//                        return $class . ' | ' . $rollno;
                        return $class . ' | ' .DT::formatDate($this->selectedDate) ;
                    }),
                TextColumn::make('rollno')
                    ->label('Roll No')
                    ->getStateUsing((function ($record) {
                        return (int)$record->studentdetails?->first()?->rollno;
                    }))
                    ->sortable(),
//                TextColumn::make('date')
//                    ->state(function () {
//                        return DT::formatDate($this->selectedDate);
//                    }),
                AttendanceColumn::make('markattendance')
                    ->label('Mark Attendance'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                //--
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
