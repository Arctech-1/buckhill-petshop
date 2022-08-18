<?php

namespace App\Services;

use App\Models\JwtTokens;
use App\Models\User;
use App\Services\JwtService;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    /**
     * Authenticate specific user
     * refresh token if user token has expired
     * @param \Illuminate\Http\Request $request
     * @param Validator $validated
     */
    static public function resolveUserLogin($validated, $request)
    {
        $error = [];

        // check if credentials exists
        $user = User::where('email', $validated['email'])->first();
        if ($user) {

            // check if password is a match
            if (Hash::check($validated['password'], $user->password)) {
                $jwtService = new JwtService;
                // check if user has an exisitng token and refresh
                if ($request->bearerToken()) {
                    if ($jwtService->checkIfTokenIsExpired($request->bearerToken())) {
                        $jwtService->refreshToken($request->bearerToken());
                        return response()->json(['message' => 'Token refreshed for an extra hour'], 200);
                    }
                }

                // generate token and save to database
                $token = $jwtService->createToken($user->uuid);
                JwtTokens::create([
                    'user_id' => $user->id,
                    'unique_id' => $token,
                    'token_title' => 'Bearer Token',
                    'expires_at' => $jwtService->expiryTime,
                ]);

                return response()->json(['message' => 'Login successful', 'bearerToken' => $token], 200);
            } else {
                array_push($error, 'Password does not match.');
            }
        } else {
            array_push($error, 'Email does not match our records.');
        }



        // return the bearer token
        return response()->json(['error' => $error], 400);
    }

    static public function resolveUserLogout($token)
    {
        return JwtService::unsetToken($token);
    }
}
