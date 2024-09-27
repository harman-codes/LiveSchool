<?php

namespace App\Filament\Parent\Widgets;


use App\Helpers\DT;
use App\Helpers\ED;
use App\Helpers\SessionYears;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Actions;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class AttendanceCalendarForParentsWidget extends FullCalendarWidget
{

    public Model|string|null $model = Attendance::class;

    public function config(): array
    {
        return [
            'firstDay' => 1,
            'headerToolbar' => [
                'left' => 'dayGridMonth,dayGridWeek,dayGridDay',
                'center' => 'title',
                'right' => 'prev,next today',
            ],
        ];
    }

    protected function headerActions(): array
    {
        return [
            //
        ];
    }

    protected function viewAction(): Actions\ViewAction
    {
        return Actions\ViewAction::make()
            ->hidden();
    }


    protected function modalActions(): array
    {
        return [
            //
        ];
    }

    public function onEventClick(array $event): void
    {
        //
    }



    public function fetchEvents(array $fetchInfo): array
    {

        $arrayOfPerDayAttendance = [];

        //get years from database. For example: 2024, 2025 etc. Because each session year will have 2 years.
        $years = Attendance::query()->where([
            ['sessionyear', SessionYears::currentSessionYear()],
            ['student_id', auth('parent')->user()->id]
        ])->get()->pluck('year')->toArray();


        //loop for each year.
        foreach ($years as $year) {
            $data = Attendance::query()->where([
                ['sessionyear', SessionYears::currentSessionYear()],
                ['student_id', auth('parent')->user()->id],
                ['year', $year]
            ])->first()->toArray();


            //only select columns with month names. for example: january, february, march etc.
            $monthsColumns = array_filter($data, function ($ColumnName) {
                return in_array($ColumnName, DT::$months);
            }, ARRAY_FILTER_USE_KEY);

            //loop through each column name (months as filtered above)
            foreach($monthsColumns as $columnName => $columnCellValueInKeyValPair){
                $month = ED::encodeMonth($columnName);

                //ignore the cells with null values. Select in which attendance is marked in json cell.
                if(!empty($columnCellValueInKeyValPair)){
                    foreach($columnCellValueInKeyValPair as $day=>$attendanceVal){
                        $date = $data['year'].'-'.ED::addZeroToSingleDigitNumber(ED::encodeMonth($columnName)).'-'.ED::addZeroToSingleDigitNumber($day);
                        $arrayOfPerDayAttendance[] = ['start'=>$date, 'end'=>$date, 'display'=>'background', 'backgroundColor'=>ED::colorForAttendanceValue($attendanceVal)];
                    }
                }
            }
        }

//        info($arrayOfPerDayAttendance);
        return $arrayOfPerDayAttendance;
    }


//    public function fetchEvents(array $fetchInfo): array
//    {
//        $data = Attendance::query()->where([
//            ['sessionyear', SessionYears::currentSessionYear()],
////            ['student_id', 2],
//            ['year', '2024']
//        ])
//            ->get()
//            ->map(function (Attendance $attendance) {
//                //Now we are in a row, and we have to make array of data from columns
//                $date = '2024-09-24';
//                $year = DT::getYearFromDate($date);
//                $month = DT::getMonthFromDate($date);
//                $day = DT::getDayFromDate($date);
//
//                return [
////                    'id' => $attendance->student_id,
//                    'start' => $date,
//                    'end' => $date,
//                    'display' => 'background',
//                    'backgroundColor' => 'red',
//                ];
//            })->all();
//
//        info($data);
//        return $data;
//
//    }

}
