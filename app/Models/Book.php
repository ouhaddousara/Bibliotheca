<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'title',
        'author',
        'publisher',
        'year',
        'category',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
        ];
    }

    public function copies(): HasMany
    {
        return $this->hasMany(Copy::class);
    }
}