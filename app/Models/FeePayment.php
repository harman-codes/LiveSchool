<?php

namespace App\Models;

use App\Helpers\DT;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{

    protected function paymentDate() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => DT::formatDate($value, 'd-m-Y'),
        );
    }
}
