<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'jwt'], function () {
    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
});
/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/
Route::post('register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
Route::get('get-user-id', [App\Http\Controllers\AuthController::class, 'getUserId']);



/*
|--------------------------------------------------------------------------
| MOVIE ROUTES
|--------------------------------------------------------------------------
*/
Route::post('movie', [App\Http\Controllers\MovieController::class, 'store']);
Route::post('movies', [App\Http\Controllers\MovieController::class, 'insert']);
Route::get('movies', [App\Http\Controllers\MovieController::class, 'index']);
Route::get('movies/{id}', [App\Http\Controllers\MovieController::class, 'show']);
Route::put('movies/{id}', [App\Http\Controllers\MovieController::class, 'update']);
Route::delete('movie/{id}', [App\Http\Controllers\MovieController::class, 'delete']);
Route::get('estrenos', [App\Http\Controllers\MovieController::class, 'getEstrenos']);
Route::get('title/{id}', [App\Http\Controllers\MovieController::class, 'getTitle']);


/*
|--------------------------------------------------------------------------
| GENRE ROUTES
|--------------------------------------------------------------------------
*/
Route::post('genres', [App\Http\Controllers\GenreController::class, 'insert']);
Route::get('genres', [App\Http\Controllers\GenreController::class, 'index']);
Route::get('genres/{id}', [App\Http\Controllers\GenreController::class, 'show']);
Route::put('genres/{id}', [App\Http\Controllers\GenreController::class, 'update']);
Route::delete('genres/{id}', [App\Http\Controllers\GenreController::class, 'destroy']);


/*
|--------------------------------------------------------------------------
| SEAT ROUTES
|--------------------------------------------------------------------------
*/
Route::get('seats', [App\Http\Controllers\SeatController::class, 'index']);
Route::get('seats/{id}', [App\Http\Controllers\SeatController::class, 'show']);
Route::post('seats', [App\Http\Controllers\SeatController::class, 'insert']);
Route::delete('seats/{id}', [App\Http\Controllers\SeatController::class, 'delete']);
Route::post('seats/{id}', [App\Http\Controllers\SeatController::class, 'create']);
Route::put('seats/{id}', [App\Http\Controllers\SeatController::class, 'update']);
Route::get('seat', [App\Http\Controllers\SeatController::class, 'getSeat']);

/*
|--------------------------------------------------------------------------
| CECKOUT ROUTES
|--------------------------------------------------------------------------
*/
Route::get('checkouts', [App\Http\Controllers\CheckoutController::class, 'index']);
Route::get('checkouts/{id}', [App\Http\Controllers\CheckoutController::class, 'showBasedOnUserId']);
Route::post('checkout', [App\Http\Controllers\CheckoutController::class, 'store']);
Route::delete('checkout/{id}', [App\Http\Controllers\CheckoutController::class, 'destroy']);
Route::put('checkout/{id}', [App\Http\Controllers\CheckoutController::class, 'update']);
Route::get('checkout/{id}', [App\Http\Controllers\CheckoutController::class, 'show']);
Route::get('watchers/{id}', [App\Http\Controllers\CheckoutController::class, 'getMovieWatchers']);