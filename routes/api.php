<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Place;
use App\Http\Controllers\PlacesController;

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
Route::post('/places', [PlacesController::class, 'create']);
// List
Route::get('/places', [PlacesController::class, 'index']);
// Show
Route::get('places/{id}', [PlacesController::class, 'show']);
// Update
Route::put('/places/{id}', [PlacesController::class, 'update']);
// Delete
Route::delete('/places/{id}', [PlacesController::class, 'delete']);