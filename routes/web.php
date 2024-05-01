<?php

use App\Http\Controllers\RegisterUserController;

use App\Http\Controllers\LocationController;

use App\Http\Controllers\ConcertController;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\DB;

//import model genre
use App\Models\Genre; 

Route::get('/', function () {
    return view('welcome');
});
//route resource for locations
Route::resource('/locations', \App\Http\Controllers\LocationController::class);

//route resource for genres
Route::resource('/genres', \App\Http\Controllers\GenreController::class);

//route resource for concerts
Route::resource('/concerts', \App\Http\Controllers\ConcertController::class);

Route::get('/genre_list/{id}', function ($id) {
    $genres = DB::table('genres')
        ->join('location_genre', 'genres.id', '=', 'location_genre.genre_id')
        ->join('locations', 'locations.id', '=', 'location_genre.location_id')
        ->select(['genres.id', 'genres.genre_music'])
        ->where('locations.id', '=', $id)
        ->get();
    
    return $genres->toJson();
  });

Route::get('/register',[RegisterUserController::class,'register'])->name('register');

Route::post('/register',[RegisterUserController::class,'store'])->name('register.store');

Route::put('locations/{location}/update', [LocationController::class, 'update'])->name('locations.update');

Route::put('concerts/{concert}/update', [ConcertController::class, 'update'])->name('concerts.update');
