<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Classtest extends Model
{
    use HasFactory;


//    public function schoolclass(): BelongsTo
//    {
//        return $this->belongsTo(Schoolclass::class);
//    }

    protected function casts()
    {
        return [
            'marksobtained' => 'array',
        ];
    }
}
