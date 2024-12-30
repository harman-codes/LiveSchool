<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Announcement extends Model
{
    use HasFactory;

    protected function casts()
    {
        return [
            'pics' => 'array',
            'original_file_names' => 'array',
        ];
    }


    public function schoolclasses(): BelongsToMany
    {
        return $this->belongsToMany(Schoolclass::class);
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
