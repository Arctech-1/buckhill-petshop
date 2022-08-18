<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminUserRequest;
use App\Http\Requests\Admin\UpdateAdminUserRequest;
use App\Models\User;
use App\Services\AuthService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



    /**
     * @OA\Post(
     *      path="/admin/create",
     *      operationId="storeUser",
     *      tags={"Users"},
     *      summary="Store new user",
     *      description="Returns success message",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreAdminUserRequest")
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

    public function store(StoreAdminUserRequest $request)
    {


        $validated = $request->validated();

        $password = Hash::make($validated['password']);
        $user = User::create(['uuid' => Str::uuid(), 'first_name' => $validated['first_name'], 'last_name' => $validated['last_name'], 'email' => $validated['email'], 'password' => $password, 'is_admin' => 0, 'email_verified_at' => Carbon::now(), 'avatar' => $validated['avatar'], 'address' => $validated['address'], 'phone_number' => $validated['phone_number'], 'is_marketing' => 0]);
        return response()->json(['message' => ['user created successfully'], 'user' => $user], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            return response()->json(['error' => ['message' => 'user not found']], 404);
        }
        return response()->json(['data' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * @OA\Put(
     *      path="/admin/user-edit/{uuid}",
     *      operationId="updateUser",
     *      tags={"Users"},
     *      summary="Update existing user",
     *      description="Returns updated user data",
     *      @OA\Parameter(
     *          name="uuid",
     *          description="User uuid",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          @OA\Schema(
     *              @OA\Property(
     *                    property="_method",
     *                    type="string",
     *                    required=true
     *                )
     *           ),
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateAdminUserRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
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
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

    public function update(UpdateAdminUserRequest $request, $uuid)
    {



        $validated = $request->validated();

        $password = Hash::make($validated['password']);
        $user = User::where(['uuid' => $uuid, 'is_admin' => 0])->first();
        if (!$user) {
            return response()->json(['error' => ['message' => 'user not found']], 404);
        }
        $user->update($validated);
        // $user->update(['uuid' => Str::uuid(), 'first_name' => $validated['first_name'], 'last_name' => $validated['last_name'], 'email' => $validated['email'], 'password' => $password, 'is_admin' => 0, 'email_verified_at' => Carbon::now(), 'avatar' => $validated['avatar'], 'address' => $validated['address'], 'phone_number' => $validated['phone_number'], 'is_marketing' => $validated['marketing'] ?? 0]);

        return response()->json(['message' => ['user updated successfully'], 'user' => $user], 202);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Delete(
     *      path="/admin/user-delete/{uuid}",
     *      operationId="deleteUser",
     *      tags={"Users"},
     *      summary="Delete existing user",
     *      description="Deletes a record and returns a message",
     *      @OA\Parameter(
     *          name="uuid",
     *          description="User uuid",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *       @OA\RequestBody(
     *          @OA\Schema(
     *              @OA\Property(
     *                    property="_method",
     *                    type="string",
     *                    required=true
     *                )
     *           ),
     *       ),
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

    public function destroy($uuid)
    {



        $user = User::where(['uuid' => $uuid, 'is_admin' => 0])->delete();
        if (!$user) {
            return response()->json(['error' => ['message' => 'user not found']], 404);
        }
        return response()->json(['data' => 'user deleted'], 200);
    }

    /**
     * Authenticate specific admin user
     * @param \Illuminate\Http\Request  $request
     */


    /**
     * @OA\Post(
     *      path="/admin/login",
     *      operationId="loginAdminUser",
     *      summary="Authenticate user credential and get bearer token and also to refresh token if expired",
     *      description="Returns success message with bearer token",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
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
     *      path="/admin/logout",
     *      operationId="logoutAdminUser",
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
}
