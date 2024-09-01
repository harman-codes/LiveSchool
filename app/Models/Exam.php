<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exam extends Model
{
    use HasFactory;



    public function schoolclass(): BelongsTo
    {
        return $this->belongsTo(Schoolclass::class);
    }


    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class);
    }


    protected function casts()
    {
        return [
            'maxmarks' => 'array',
        ];
    }
}
