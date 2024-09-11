<?php
namespace App\Helpers;

class Config{
//    public static $mapkey = env('MAP_KEY', null);
    public static function mapkey(){
        return env('MAP_KEY', null);
    }
}
