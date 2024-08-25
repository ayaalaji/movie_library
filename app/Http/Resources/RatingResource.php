<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'User Name' =>$this->user->name,
            'Movie'=>$this->movie->title,
            'rating'=>$this->rating,
            'review'=>$this->review,
            'created_at'=>$this->created_at->format('Y-m-d')

        ];
    }
}
