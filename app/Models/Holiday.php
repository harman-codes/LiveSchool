<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $appends = ['holiday'];

    protected function holiday(): Attribute
    {
        return Attribute::make(function(mixed $value, array $attributes){
            $date = Carbon::parse($attributes['date'])->format('d-M-Y');
            $from = Carbon::parse($attributes['from'])->format('d-M-Y');
            $to = Carbon::parse($attributes['to'])->format('d-M-Y');
            return $attributes['is_singleday'] ? $date : $from . ' to ' . $to;
        });
    }

}
