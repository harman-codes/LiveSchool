<?php

namespace App\Models;

use App\Helpers\SessionYears;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts()
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function studentdetails() : HasMany
    {
        return $this->hasMany(Studentdetail::class);
//        return $this->hasMany(Studentdetail::class)->where('sessionyear', '=', SessionYears::currentSessionYear());
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
