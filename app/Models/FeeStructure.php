<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FeeStructure extends Model
{
    use HasFactory;

    protected $casts = [
        'schoolclass_id' => 'array',
    ];


    public function schoolclasses(): BelongsToMany
    {
        return $this->belongsToMany(Schoolclass::class)
            ->withPivot('sessionyear');
    }


    /*Attribute Casts to format date to d-m-Y format*/
    protected function from(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('d-m-Y', strtotime($value)),
        );
    }

    protected function to(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('d-m-Y', strtotime($value)),
        );
    }

    protected function lastdate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('d-m-Y', strtotime($value)),
        );
    }
}
