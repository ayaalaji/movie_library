<?php

namespace App\Http\Controllers\Api;

use App\Models\Rating;
use Illuminate\Http\Request;
use App\Traits\apiResponseTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\RatingResource;
use App\Http\Requests\RatingStoreRequest;
use App\Http\Requests\UpdateRatingRequest;

class RatingController extends Controller
{
    use apiResponseTrait;

    /**
     * get all rating that users do it 
     */
    public function index()
    {
        try{
           $ratings=RatingResource::collection(Rating::all());
           return $this->responseApi($ratings,'index successfully',200);
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            return $this->responseApi(null,'something went wrong when you want to see all ratings',400);
        }    
    }

   /**
     * Store a newly movie in database.
     * @param RatingRequest $request
     * @return /Illuminate\Http\JsonResponse
     */
    public function store(RatingStoreRequest $request)
    {
        try{
            
            $request->validated();
            $user_id = auth()->user()->id;
              $rating = Rating::create([
                'user_id' => $user_id,
                'movie_id' => $request->movie_id,
                'rating' => $request->rating,
                'review' => $request->review,
            ]);
           
            $rating->save();
            return $this->responseApi(new RatingResource($rating),'you add rating successfully',201);
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            return $this->responseApi(null,'something went wrong when you add rating,sorry',400);
        }
    }
    /**
     * Update the specified rating.
     * @param UpdateRatingRequest $request
     * @return /Illuminate\Http\JsonResponse
     */
    public function update(UpdateRatingRequest $request, Rating $rating)
    {
        try{
           $request->validated();
           
           if ($rating->user_id !== auth()->user()->id) {
              return $this->responseApi( null,'You can not edit ,because this rating is not yours',400);
           }
           else{
               $rating->movie_id=$request->movie_id ??$rating->movie_id;
               $rating->rating=$request->rating??$rating->rating;
               $rating->review=$request->review??$rating->review;
               $rating->save();
               return $this->responseApi(new RatingResource($rating),'you updated rating successfully',201);
           }
        }catch (\Exception $th) {
            Log::error($th->getMessage());
            return $this->responseApi(null,'something went wrong when you update rating,sorry',400);
        }
    }

    /**
     * Remove the specified rating .
     * @param Rating $rating
     * @return /Illuminate\Http\JsonResponse
     */
    public function destroy(Rating $rating)
    {
        try{
           if ($rating->user_id !== auth()->user()->id) {
             return $this->responseApi(null,'You can not delete ,because this rating is not yours',400);
           }
           else{
              $rating->delete();
              return $this->responseApi(null,'you deleted successfully',204);
           }
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            return $this->apiResponse('something went wrong when you delete rating ,sorry',204);
        }
    }
}
