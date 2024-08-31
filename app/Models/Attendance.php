<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected function casts()
    {
        return [
            'january' => 'array',
            'february' => 'array',
            'march' => 'array',
            'april' => 'array',
            'may' => 'array',
            'june' => 'array',
            'july' => 'array',
            'august' => 'array',
            'september' => 'array',
            'october' => 'array',
            'november' => 'array',
            'december' => 'array'
        ];
    }


    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
