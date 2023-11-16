<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Place;

class PlacesController extends Controller
{
    public function create(Request $request)
    {
        $place = $request->all();

        $validator = Validator::make(
            $place,
            $rules = [
                'name' => 'required|alpha_num|max:255',
                'postalCode' => 'nullable|size:5'
            ]
        );

        if( $validator->fails() ){
            return $validator->errors();
        }

        $newPlaceSaved = false;

        $newPlace = new Place;
        $newPlace->fill($place);
        $newPlace->save();

        $newPlaceSaved = true;

        return response()->json([
            'newPlaceSaved' => $newPlaceSaved
        ]);
    }

    public function index()
    {
        /*$places = \DB::table('places')->get();*/
        $places = Place::all();

        return response()->json([
            'places' => $places
        ]);
    }

    public function show($id)
    {
        $place = Place::where('id', $id)->first();

        return response()->json([
            'place' => $place
        ]);
    }

    public function update(Request $request, $id)
    {
        $place = $request->all();
        $placeUpdated = false;

        $placeToUpdate = Place::where('id', $id)->first();
        $placeToUpdate->fill($place);
        $placeToUpdate->save();

        $placeUpdated = true;

        return response()->json([
            'placeUpdated' => $placeUpdated
        ]);
    }

    public function delete($id)
    {
        $placedDeleted = false;

        Place::where('id', $id)->delete();

        $placedDeleted = true;

        return response()->json([
            'placeDeleted' => $placedDeleted
        ]);
    }
}
