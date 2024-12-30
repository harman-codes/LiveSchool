<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bookcategory extends Model
{
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
