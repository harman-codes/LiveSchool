<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TimeTableSlot extends Model
{
    /*hasmany TimeTable*/
    public function timetables(): HasMany
    {
        return $this->hasMany(TimeTable::class);
    }

    /*belongsto SchoolClass*/
    public function schoolclass(): BelongsTo
    {
        return $this->belongsTo(Schoolclass::class);
    }
}
