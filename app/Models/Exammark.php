<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exammark extends Model
{
    use HasFactory;

    protected function casts()
    {
        return [
            'marksobtained' => 'array',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }


    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }
}
