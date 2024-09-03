<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function exammarks(): HasMany
    {
        return $this->hasMany(Exammark::class);
    }

    protected function casts()
    {
        return [
            'maxmarks' => 'array',
        ];
    }
}
