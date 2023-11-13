<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
    function login(Request $request)
    {
        $credentials = $request->all();
        $token = null;

        $user = User::where('email', $credentials['username'])->first();

        if( Hash::check($credentials['password'], $user->password) ){
            $token = $user->createToken('API Token Portal of ' . $user->id)->accessToken;
        }

        return response()->json([
            'token' => $token
        ]);
    }
}
