<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\JwtService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *      path="/user",
     *      operationId="getUser",
     *      summary="Get user information",
     *      description="Returns users data. always pass the bearer token",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function index(Request $request)
    {
        // get user uuid
        $jwt = new JwtService;
        $uuid = $jwt->getUserTokenUuid($request->bearerToken());
        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            return response()->json(['error' => ['message' => 'User not found']], 404);
        }
        return response()->json(['data' => ['user' => $user]], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get user uuid from bearer token.

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Authenticate specific admin user
     * @param \Illuminate\Http\Request  $request
     */

    /**
     * @OA\Post(
     *      path="/user/login",
     *      operationId="loginUser",
     *      summary="Authenticate user credential and get bearer token and also to refresh token if expired",
     *      description="Returns success message with bearer token",
     *      @OA\RequestBody(
     *          required=true,
     *           @OA\MediaType(
     *           mediaType="application/json",
     *          @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                      
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     
     *                 ), 
     *           ),
     *           @OA\Schema(
     *              type="integer"
     *          ),
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */


    public function login(Request $request)
    {
        // validate request input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        return AuthService::resolveUserLogin($validated, $request);
    }

    /**
     * Logout specific admin user
     * @param int id
     */

    /**
     * @OA\Post(
     *      path="/user/logout",
     *      operationId="logoutUser",
     *      summary="Logout user.",
     *      description="Unsets the bearer token a record and returns a message",
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */


    public function logout(Request $request)
    {
        if (AuthService::resolveUserLogout($request->bearerToken())) {
            return response()->json(['success' => 'Logged out successfully. Token is unset']);
        }
        return response()->json(['error' => 'Token not found'], 200);
    }



    /**
     * @OA\Post(
     *      path="/user/forgot-password",
     *      operationId="forgotUserPassword",
     *      summary="Authenticate user credential and get bearer token and also to refresh token if expired",
     *      description="Returns success message with bearer token",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                      required=true
     *                 ),
     *               
     *           ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function forgotPassword(Request $request)
    {
        // validate email
        $request->validate([
            'email' => 'required|email',
        ]);
        //check if email exist in records
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['error' => ['message' => 'email does not exist']], 404);
        }
        $userUuid = $user->uuid;

        //generate a token
        $jwt = new JwtService;

        $token = $jwt->resetPasswordToken($userUuid);
        PasswordReset::create(['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]);
        return response()->json(['data' => ['token' => $token]]);
    }



    /**
     * @OA\Post(
     *      path="/user/reset-password-token",
     *      operationId="resetUserPassword",
     *      summary="Authenticate user credential and get bearer token and also to refresh token if expired",
     *      description="Returns success message with bearer token",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\Schema(
     *                 @OA\Property(
     *                     property="token",
     *                     type="string",
     *                      required=true
     *                 ),
     *                   @OA\Property(
     *                     property="email",
     *                     type="string",
     *                      required=true
     *                 ),
     *               @OA\Property(
     *                     property="password",
     *                     type="string",
     *                      required=true
     *                 ),
     *               
     *           ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function resetPassword(Request $request)
    {
        if (!$request->token) {
            return response()->json(['error' => ['message' => 'no token found']], 400);
        }
        $validated =  $request->validate([
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()],
        ]);
        $password = Hash::make($validated['password']);
        // 
        $user = User::where('email', $validated['email'])->update(['password' => $password]);
        return response()->json(['message' => ' password updated']);
    }
}
