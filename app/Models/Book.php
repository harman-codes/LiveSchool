<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function schoolclasses(): BelongsToMany
    {
        return $this->belongsToMany(Schoolclass::class);
    }

    public function bookcategory(): BelongsTo
    {
        return $this->belongsTo(Bookcategory::class);
    }


    public function bookissues(): HasMany
    {
        return $this->hasMany(Bookissue::class);
    }
}
