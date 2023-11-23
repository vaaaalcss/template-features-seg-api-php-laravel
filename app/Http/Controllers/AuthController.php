<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    function login(Request $request)
    {
        $tooManyAttempts = false;
        $token = null;

        $executed = RateLimiter::attempt(
            $request->ip(),
            $perTwoMinutes = 3, // Attempts
            function() {
                // Some action
            },
            $decayRate = 120, // Every two minutes
        );

        if ( !$executed ) {
          $tooManyAttempts = true;
        } else {

            $credentials = $request->all();
            $currentDate = Carbon::now();

            $user = User::where('email', $credentials['username'])->first();

            if( $user ){
                $checkSession = !$user->sessionStartedAt ||
                                $currentDate->diffInMinutes($user->sessionStartedAt) > 10;

                if( $checkSession ) {
                    if( Hash::check($credentials['password'], $user->password) ){
                        $token = $user->createToken('api-security')->accessToken;
                        $user->sessionStartedAt = Carbon::now();
                        $user->save();

                        RateLimiter::clear($request->ip());
                    }
                }
            }
        }


        return response()->json([
            'token' => $token,
            'tooManyAttempts' => $tooManyAttempts
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
