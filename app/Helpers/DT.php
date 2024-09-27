<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

class DT
{

    public static $months = [
        'january',
        'february',
        'march',
        'april',
        'may',
        'june',
        'july',
        'august',
        'september',
        'october',
        'november',
        'december'
    ];



//    public function __construct()
//    {
////      $dt = Carbon::now('+05:30');
//        $dt = Carbon::now('Asia/Calcutta');
//        $this->currentYear = $dt->year;
//        $this->currentMonth = $dt->month;
//        $this->currentDay = $dt->day;
//        $this->currentHour = $dt->hour;
//        $this->currentMinute = $dt->minute;
//        $this->currentSecond = $dt->second;
//        $this->currentDate = $dt->format('d-m-Y');
//        $this->currentTime = $dt->format('H:i:s');
//        $this->currentMonthNoOfDays = $dt->daysInMonth;
//    }


    public static function dt()
    {
        return Carbon::now('Asia/Calcutta');
    }

    public static function currentYear()
    {
        return self::dt()->year;
    }

    public static function currentMonth() //Numeric value
    {
        return self::dt()->month;
    }

    public static function currentMonthName()
    {
        return ED::decodeMonth(self::dt()->month);
    }

    public static function getDayFromDate($date)
    {
        return Carbon::parse($date)->day;
    }

    public static function getMonthFromDate($date)
    {
        return Carbon::parse($date)->month;
    }
    public static function getMonthNameFromDate($date)
    {
        //january, february ans so on
        return ED::decodeMonth(Carbon::parse($date)->month);
    }

    public static function getYearFromDate($date)
    {
        return Carbon::parse($date)->year;
    }

    public static function currentDay()
    {
        return self::dt()->day;
    }

    public static function currentHour()
    {
        return self::dt()->hour;
    }

    public static function currentMinute()
    {
        return self::dt()->minute;
    }

    public static function currentSecond()
    {
        return self::dt()->second;
    }

    public static function currentDate()
    {
        return self::dt()->format('d-m-Y');
    }

    public static function currentTime()
    {
        return self::dt()->format('H:i:s');
    }

    public static function currentMonthNoOfDays()
    {
        return self::dt()->daysInMonth;
    }

    public static function formatDate($date,$format = 'd-m-Y')
    {
        return Carbon::parse($date)->format($format);
    }

    public static function isTimePassed($time, $min = 2)
    {
        return Carbon::parse($time)->isBefore(now()->subMinutes($min));
    }

}
