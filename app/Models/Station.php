<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Station extends Model
{
    protected $fillable = [
        'name',
        'line_name',
        'city',
        'image_url',
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function publicReviews(): HasMany
    {
        return $this->reviews()
            ->where('is_private', false);
    }
}