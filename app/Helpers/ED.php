<?php

namespace App\Helpers;
class ED
{
    public static function encodeMonth($stringVal)
    {
        $arr = array(
            'january' => 1,
            'february' => 2,
            'march' => 3,
            'april' => 4,
            'may' => 5,
            'june' => 6,
            'july' => 7,
            'august' => 8,
            'september' => 9,
            'october' => 10,
            'november' => 11,
            'december' => 12
        );
        return (int)$arr[$stringVal];
    }

    public static function decodeMonth($numericVal)
    {
        //accepts both 1 and 01
        $arr = array(
            1 => 'january',
            2 => 'february',
            3 => 'march',
            4 => 'april',
            5 => 'may',
            6 => 'june',
            7 => 'july',
            8 => 'august',
            9 => 'september',
            10 => 'october',
            11 => 'november',
            12 => 'december'
        );
        return (string)$arr[(int)$numericVal];
    }


    public static function encodeSlug($val)
    {
        $val = trim($val);
        return preg_replace(['#%20#si', '# #si'],['_','_'],$val);
    }

    public static function decodeSlug($val)
    {
        $val = trim($val);
        return str_replace('_', ' ', $val);
    }

}
