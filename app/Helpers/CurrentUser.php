<?php

namespace App\Helpers;

use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class CurrentUser
{

    public static function user()
    {
        //if school staff
        if (Auth::check()) {
            return Auth::user();
        }elseif(Auth::guard('driver')->user()){
            return Auth::guard('driver')->user();
        }
        else {
            return Auth::guard('parent')->user();
        }
    }

//    public static function role()
//    {
//        return self::user()->role;
//    }

//    public static function is_admin()
//    {
//        return self::user()->role == 'admin';
//    }
//
//    public static function is_principal()
//    {
//        return self::user()->role == 'principal';
//    }
//
//    public static function is_adminOrPrincipal()
//    {
//        if(self::user()->role == 'admin'){
//            return true;
//        }elseif(self::user()->role == 'principal'){
//            return true;
//        }else{
//            return false;
//        }
//    }
//
//    public static function is_teacher()
//    {
//        return self::user()->role == 'teacher';
//    }
//
//    public static function is_parent()
//    {
//        return self::user()->role == 'parent';
//    }
//
//    public static function is_driver()
//    {
//        return self::user()->role == 'driver';
//    }

    public static function id()
    {
        return self::user()->id;
    }

    public static function name()
    {
        return self::user()->name;
    }

    public static function classId()
    {
        //if parent
        return auth('parent')->user()->studentdetails->first()?->schoolclass->id;
//        return Student::where('id', auth('parent')->user()->id)->withWhereHas('studentdetails', function ($query){
//            $query->where('sessionyear', SessionYears::currentSessionYear())->with(['schoolclass']);
//        })?->first()?->studentdetails?->first()?->schoolclass->id;
    }

    public static function studentdetails()
    {
        return Student::where('id', auth('parent')->user()->id)->withWhereHas('studentdetails', function ($query){
            $query->where('sessionyear', SessionYears::currentSessionYear())->with(['schoolclass']);
        })?->first()?->studentdetails?->first();
    }

    public static function classNameWithSection()
    {
        return Student::where('id', auth('parent')->user()->id)->withWhereHas('studentdetails', function ($query){
            $query->where('sessionyear', SessionYears::currentSessionYear())->with(['schoolclass']);
        })?->first()?->studentdetails?->first()?->schoolclass->classwithsection;
    }

}
