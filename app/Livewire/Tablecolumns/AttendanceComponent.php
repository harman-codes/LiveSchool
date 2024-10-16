<?php

namespace App\Livewire\Tablecolumns;

use App\Helpers\DT;
use App\Helpers\Notify;
use App\Helpers\SessionYears;
use App\Models\Attendance;
use App\Models\Student;
use Livewire\Component;

class AttendanceComponent extends Component
{
    /*Set from table*/
    public $record;
    public $selectedDate;
    public $selectedClass;

    /*Custom Properties*/
    public $attendanceOption;
    public $day;
    public $month;
    public $year;

    public function markAttendance($option)
    {

        $classWithSection = $this->record->studentdetails->where('sessionyear', SessionYears::currentSessionYear())?->first()?->schoolclass->classwithsection ?? null;

        if(!empty($this->record->id)&&!empty($this->selectedDate)&&!empty($classWithSection)){
            $day = $this->day;
            $month = $this->month;
            $year = $this->year;

            //If button pressed of already marked attendance. Unmark it. set empty value.
            if($this->attendanceOption==$option){
                $option = '';
            }

            Attendance::updateOrCreate(
                [
                    'sessionyear' => SessionYears::currentSessionYear(),
                    'year' => $this->year,
                    'student_id' => $this->record->id
                ],
                [
                    'classname' => $classWithSection,
                    $month.'->'.$day => $option
                ]
            );
        }else{
            Notify::fail('Error: Please assign class first.');
        }
    }



    public function render()
    {
        if (!empty($this->record->id) && !empty($this->selectedDate)) {
                $day = DT::getDayFromDate($this->selectedDate);
                $month = DT::getMonthNameFromDate($this->selectedDate);
                $year = DT::getYearFromDate($this->selectedDate);

                /*Get attendance from database and set attendanceOption property*/
                $val = Attendance::where([
                    ['student_id', $this->record->id],
                    ['sessionyear', SessionYears::currentSessionYear()],
                    ['year', $year]
                ])->whereNotNull($month . '->' . $day)->first();

                if (!empty($val)) {
                    $this->attendanceOption = $val->$month[$day];
                }

                $this->day = $day;
                $this->month = $month;
                $this->year = $year;
        }
        return view('livewire.tablecolumns.attendance-component');
    }
} //class ends
