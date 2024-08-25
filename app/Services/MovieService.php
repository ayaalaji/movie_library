<?php
namespace App\Services;

use App\Models\Movie;
use App\Traits\apiResponseTrait;
use Illuminate\Support\Facades\Auth;

class MovieService{
    use apiResponseTrait;

    //get all movies in data base and return to user with sorting,pagnation,filtering
    public function getAllMovies(array $data){
        $query = Movie::query();
        //filtering using genre
        if (isset($data['genre'])) {
            $query->where('genre', $data['genre']);
        }
        //filtering using genre
        if (isset($data['director'])) {
            $query->where('director', $data['director']);
        }

        // sorting the movies from modern    
        $query->orderBy('release_year', 'desc');

        // Apply pagination with the number of movies per page and the page number 
        $perPage = $data['per_page'] ?? 10;
        $page = $data['page'] ?? 1;  
        return $query->paginate($perPage, ['*'], 'page', $page);
    }
    //add new movie
    public function createMovie(array $data){
        $user =Auth::user();
        if ($user->role !== 'admin') {
            return response('You cannot update this movie.', 403);
        }
        return Movie::create($data);
    }
    // show specific movie 
     public function showMovie(Movie $movie)
    {
        return $movie;
    }
    // update movie 
    public function updateMovie(Movie $movie, array $data)
    {
        $user =Auth::user();
        if ($user->role !== 'admin') {
            return $this->apiResponse('You cannot update this movie.', 403);
        }
        $movie->update($data);
        return $this->responseApi($movie,'you updated successfully',201);
    }

    //delete specific movie
    public function deleteMovie(Movie $movie)
    {
        $user =Auth::user();
        if ($user->role !== 'admin') {
            return $this->apiResponse('You cannot delete this movie.', 403);
        }

        $movie->delete();

        return $this->apiResponse(null, 204); 
        
    } 
}