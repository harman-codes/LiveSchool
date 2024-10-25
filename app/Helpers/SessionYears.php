<?php
namespace App\Helpers;
use App\Models\CurrentSessionYear;

class SessionYears{

    public static function years()
    {
        $years = array(
            '2024-25'=>'2024-25',
            '2025-26'=>'2025-26',
            '2026-27'=>'2026-27',
            '2027-28'=>'2027-28',
            '2028-29'=>'2028-29',
            '2029-30'=>'2029-30',
            '2030-31'=>'2030-31',
            '2031-32'=>'2031-32',
            '2032-33'=>'2032-33',
            '2033-34'=>'2033-34',
            '2034-35'=>'2034-35',
            '2035-36'=>'2035-36',
            '2036-37'=>'2036-37',
            '2037-38'=>'2037-38',
            '2038-39'=>'2038-39',
            '2039-40'=>'2039-40',
        );
        return $years; //key=>value pair
    }


    public static function currentSessionYear()
    {
        return CurrentSessionYear::find(1)?->first()?->sessionyear;
    }

}
