<?php

namespace App\Helpers;

class Role
{
    public static array $rolesKeyValuePair = [
//        'admin' => 'Admin',
        'management' => 'Management',
        'principal' => 'Principal',
        'manager' => 'Manager',
        'teacher' => 'Teacher',
        'finance' => 'Finance',
        'librarian' => 'Librarian',
    ];

    public static function roles(): array
    {
        return array_keys(self::$rolesKeyValuePair);
    }

    public static function isAdmin(): bool
    {
        return auth()->user()->is_admin == true;
    }

    public static function isManagement(): bool
    {
        return auth()->user()->role == 'management';
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

    public static function isLibrarian(): bool
    {
        return auth()->user()->role == 'librarian';
    }

    public static function isAdminOrManagementOrPrincipalOrManager(): bool
    {
        return self::isAdmin() || self::isManagement() || self::isPrincipal() || self::isManager();
    }

}
