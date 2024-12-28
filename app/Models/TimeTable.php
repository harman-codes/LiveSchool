<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeTable extends Model
{
    /*relation with schoolclass*/
    public function schoolclass(): BelongsTo
    {
        return $this->belongsTo(Schoolclass::class);
    }

    /*belongs to TimeTableSlot*/
    public function timetableslot(): BelongsTo
    {
        return $this->belongsTo(TimeTableSlot::class);
    }


    /*Accessor*/
    protected function from(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => date('h:i A', strtotime($value)),
        );
    }

    protected function to(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => date('h:i A', strtotime($value)),
        );
    }

}
