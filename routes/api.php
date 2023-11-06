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

// Create
Route::post('/places', function(Request $request){
    $place = $request->all();
    $newPlaceSaved = false;

    $newPlace = new Place;
    $newPlace->name = $place['name'];
    $newPlace->open = $place['open'];
    $newPlace->save();

    $newPlaceSaved = true;

    return response()->json([
        'newPlaceSaved' => $newPlaceSaved
    ]);
});

// List
Route::get('/places', function(){
    $places = Place::all();

    return response()->json([
        'places' => $places
    ]);
});

// Show
Route::get('places/{id}', function($id){
    $place = Place::where('id', decrypt($id))->first();

    return response()->json([
        'place' => $place
    ]);
});

// Update
Route::put('/places/{id}', function(Request $request, $id){
    $place = $request->all();
    $placeUpdated = false;

    $placeToUpdate = Place::where('id', $id)->first();
    $placeToUpdate->name = $place['name'];
    $placeToUpdate->save();

    $placeUpdated = true;

    return response()->json([
        'placeUpdated' => $placeUpdated
    ]);
});


// Delete
Route::delete('/places/{id}', function($id){
    $placedDeleted = false;

    Place::where('id', $id)->delete();

    $placedDeleted = true;

    return response()->json([
        'placeDeleted' => $placedDeleted
    ]);
});