<?php

namespace App\Helpers;

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

    public static function role()
    {
        return self::user()->role;
    }

    public static function is_admin()
    {
        return self::user()->role == 'admin';
    }

    public static function is_principal()
    {
        return self::user()->role == 'principal';
    }

    public static function is_adminOrPrincipal()
    {
        if(self::user()->role == 'admin'){
            return true;
        }elseif(self::user()->role == 'principal'){
            return true;
        }else{
            return false;
        }
    }

    public static function is_teacher()
    {
        return self::user()->role == 'teacher';
    }

    public static function is_parent()
    {
        return self::user()->role == 'parent';
    }

    public static function is_driver()
    {
        return self::user()->role == 'driver';
    }

    public static function id()
    {
        return self::user()->id;
    }

    public static function name()
    {
        return self::user()->name;
    }

    public static function classname()
    {
        $currentSessionYear = SessionYears::currentSessionYear();
        if (self::is_parent()) {
            $classname = self::user()->withWhereHas('studentdetails', function ($query) use ($currentSessionYear) {
                $query->where('sessionyear', $currentSessionYear);
            })->first()->studentdetails->first()->classname;

            return $classname;
        } else {
            return null;
        }
    }


    public static function rollno()
    {
        $currentSessionYear = SessionYears::currentSessionYear();
        if (self::is_parent()) {
            $classname = self::user()->withWhereHas('studentdetails', function ($query) use ($currentSessionYear) {
                $query->where('sessionyear', $currentSessionYear);
            })->first()->studentdetails->first()->rollno;

            return $classname;
        } else {
            return null;
        }
    }



}
