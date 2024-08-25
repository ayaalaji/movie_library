<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Movie extends Model
{
    use HasFactory,HasApiTokens;

    protected $fillable = [
        'title',
        'director',
        'genre',
        'release_year',
        'description',
    ];
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

}
