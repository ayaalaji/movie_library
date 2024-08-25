<?php

namespace App\Http\Controllers\Api;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Services\MovieService;
use App\Http\Requests\IndexRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Traits\apiResponseTrait;

class MovieController extends Controller
{
    use apiResponseTrait;
    /**
     * Constructor to inject Movie Service Class
     * @param \App\Services\MovieService $movieService
     */
    protected $movieService;
    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }
    /**
     * get all movies
     * @param IndexRequest $request
     * @return /Illuminate\Http\JsonResponse
     */
    public function index(IndexRequest $request)
    {
        try{
           $validateData=$request->validated();
           $movies = $this->movieService->getAllMovies($validateData);
           return response()->json($movies);
        }catch(\Exception $th){
            Log::error($th->getMessage());
            return $this->apiResponse('something went wrong when you show movies,sorry',400);
        }   
    }

    /**
     * Store a newly movie in database.
     * @param StoreMovieRequest $request
     * @return /Illuminate\Http\JsonResponse
     */
    public function store(StoreMovieRequest $request)
    {
        try{
           $validateData=$request->validated();
           $movie = $this->movieService->createMovie($validateData);
           return response()->json($movie, 201);
        }catch(\Exception $th){
            Log::error($th->getMessage());
            return $this->apiResponse('something went wrong when you add movie,sorry',400);
        }     
    }

    /**
     * Display the specified movie by movie_id.
     * @param Movie $movie
     * @return /Illuminate\Http\JsonResponse
     */
    public function show(Movie $movie)
    {
        try{
           $movieDetails = $this->movieService->showMovie($movie);
           return response()->json($movieDetails);
        }  catch(\Exception $th){
            Log::error($th->getMessage());
            return $this->apiResponse('something went wrong when you show movie,sorry',400);
        }  
    }

    /**
     * Update the specified movie.
     * @param Movie $movie
     * @param UpdateMovieRequest $request
     * @return /Illuminate\Http\JsonResponse
     * 
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        try{
           $validatedData = $request->validated();
           return $this->movieService->updateMovie($movie, $validatedData);
        }catch(\Exception $th){
            Log::error($th->getMessage());
            return $this->apiResponse('something went wrong when you update movie,sorry',400);
        }    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        try{
           return $this->movieService->deleteMovie($movie);
        }catch(\Exception $th){
            Log::error($th->getMessage());
            return $this->apiResponse('something went wrong when you delete movie,sorry',400);
        }     
    }
}
