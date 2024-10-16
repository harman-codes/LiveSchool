<?php

namespace App\Helpers;

class Role
{
    public static array $rolesKeyValuePair = [
        'admin' => 'Admin',
        'principal' => 'Principal',
        'manager' => 'Manager',
        'teacher' => 'Teacher',
        'finance' => 'Finance',
    ];

    public static function roles(): array
    {
        return array_keys(self::$rolesKeyValuePair);
    }

    public static function isAdmin(): bool
    {
        return auth()->user()->role == 'admin';
    }

    public static function isPrincipal(): bool
    {
        return auth()->user()->role == 'principal';
    }

    public static function isManager(): bool
    {
        return auth()->user()->role == 'manager';
    }

    public static function isTeacher(): bool
    {
        return auth()->user()->role == 'teacher';
    }

    public static function isFinance(): bool
    {
        return auth()->user()->role == 'finance';
    }

    public static function isAdminOrPrincipal()
    {
        if (auth()->user()->role == 'admin') {
            return true;
        } elseif (auth()->user()->role == 'principal') {
            return true;
        } else {
            return false;
        }
    }

    public static function isAdminOrPrincipalOrManager()
    {
        if (auth()->user()->role == 'admin') {
            return true;
        } elseif (auth()->user()->role == 'principal') {
            return true;
        }elseif (auth()->user()->role == 'manager') {
            return true;
        } else {
            return false;
        }
    }

}
