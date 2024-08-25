<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Rating extends Model
{
    use HasFactory,HasApiTokens;

    protected $fillable = [
        'user_id',
        'movie_id',
        'rating',
        'review'
    ];
    public function movie()
    {
       return $this->belongsTo(Movie::class);
    }
    public function user()
    {
       return $this->belongsTo(User::class);
    }

}
