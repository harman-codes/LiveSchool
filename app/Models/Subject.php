<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    use HasFactory;



    public function schoolclasses(): BelongsToMany
    {
        return $this->belongsToMany(Schoolclass::class);
    }


    public function exams(): BelongsToMany
    {
        return $this->belongsToMany(Exam::class);
    }
}
