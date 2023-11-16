<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    function login(Request $request)
    {
        $credentials = $request->all();
        $token = null;
        $currentDate = Carbon::now();

        $user = User::where('email', $credentials['username'])->first();
        $checkSession = !$user->sessionStartedAt ||
                        $currentDate->diffInMinutes($user->sessionStartedAt) > 1;

        if( $user && $checkSession ) {
            if( Hash::check($credentials['password'], $user->password) ){
                $token = $user->createToken('api-security')->accessToken;
                $user->sessionStartedAt = Carbon::now();
                $user->save();
            }
        }

        return response()->json([
            'token' => $token
        ]);
    }

    function logout()
    {
        $authenticated = true;

        $userUpdate = User::find( Auth::id() );
        $userUpdate->sessionStartedAt = null;
        $userUpdate->save();

        $user = Auth::user()->token();

        if ( $user->revoke() ) {
            $authenticated = false;
        }

        return response()->json([
            'authenticated' => $authenticated
        ], 200);
    }
}
