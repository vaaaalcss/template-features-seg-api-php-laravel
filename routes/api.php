<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Place;

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

Route::get('/places', function(){
    $places = Place::all();

    return response()->json([
        'places' => $places
    ]);
});

Route::get('places/{id}', function($id){
    $place = Place::where('id', $id)->first();

    return response()->json([
        'place' => $place
    ]);
});

Route::get('places/{id}', function($id){
    $place = Place::where('id', $id)->first();

    return response()->json([
        'place' => $place
    ]);
});

Route::delete('places/{id}', function($id){
    Place::delete($id);
});