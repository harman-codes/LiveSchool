<?php

namespace App\Helpers;

use App\Models\Attendance;
use App\Models\Student;

class School
{

    public static function totalStudents()
    {
        return Student::count();
    }

    public static function attendanceTotalInSchoolInMonth($month, $type = 'P')
    {
        $counter = [];
        $data = Attendance::get($month);
        foreach ($data as $row){
            foreach($row->$month as $key=>$val){
                //in 18=P pair
                if($val==$type){
                    $counter[] = $key;
                }
            }
        }
        return count($counter);
    }


    public static function attendanceTotalInSchoolToday($type = 'P')
    {
        $month = DT::currentMonthName();
        $day = DT::currentDay();
        $result = Attendance::where($month.'->'.$day,'=',$type)->count();
        return $result;
    }


    public static function attendanceTotalInClassInMonth($month, $classSlug, $type = 'P')
    {
        if(is_numeric($month)){
            $month = ED::decodeMonth($month);
        }

        $counter = [];
        $data = Attendance::where('classname', $classSlug)->get($month);
        foreach ($data as $row){
            foreach($row->$month as $key=>$val){
                //in 18=P pair
                if($val==$type){
                    $counter[] = $key;
                }
            }
        }
        return count($counter);
    }


    public static function attendanceTotalInClassToday($classSlug, $type = 'P')
    {
        $month = DT::currentMonthName();
        $day = DT::currentDay();
        $result = Attendance::where('classname', $classSlug)->where($month.'->'.$day,'=',$type)->count();
        return $result;
    }


    public static function attendanceTotalInClassOnDate($year, $month, $day, $classSlug, $type = 'P')
    {
        if(is_numeric($month)){
            $month = ED::decodeMonth($month);
        }

        $result = Attendance::where('sessionyear', SessionYears::currentSessionYear())->where('year', $year)->where('classname', $classSlug)->where($month.'->'.$day,'=',$type)->count();
        return $result;
    }

    public static function totalStudentsInAClass($classSlug)
    {
        return (int)Student::withWhereHas('studentdetails', function($query) use ($classSlug) {
            $query->where('classname', $classSlug);
        })->count();
    }


}
