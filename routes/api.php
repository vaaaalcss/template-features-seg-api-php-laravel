<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Place;
use App\Http\Controllers\PlacesController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Hash;

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

Route::get('password', function(){
	return Hash::make('pollito123');
});

// Create
Route::post('/places', [PlacesController::class, 'create']);
// List
Route::get('/places', [PlacesController::class, 'index'])->middleware(['auth:api']);
// Show
Route::get('places/{id}', [PlacesController::class, 'show']);
// Update
Route::put('/places/{id}', [PlacesController::class, 'update']);
// Delete
Route::delete('/places/{id}', [PlacesController::class, 'delete']);
// Login
Route::post('login', [AuthController::class, 'login']);