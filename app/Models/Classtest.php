<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classtest extends Model
{
    use HasFactory;


    protected function casts()
    {
        return [
            'marksobtained' => 'array',
        ];
    }
}
