<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\RatingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/register',[AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login']);
/////////////Movie/////////////////
Route::get('movies',[MovieController::class ,'index']);
Route::get('movie/{movie}', [MovieController::class ,'show']);
//////////////Rating////////////////////
Route::get('ratings',[RatingController::class ,'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    ///////Movie/////
    Route::controller(MovieController::class)->group(function () {
        Route::post('movie', 'store');
        Route::put('movie/{movie}', 'update');
        Route::delete('movie/{movie}', 'destroy');
    });
    //////////////Rating/////////////
    Route::controller(RatingController::class)->group(function () {
        Route::post('rating', 'store');
        Route::put('rating/{rating}', 'update');
        Route::delete('rating/{rating}', 'destroy');
    });
});

