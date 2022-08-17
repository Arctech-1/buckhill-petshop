<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminUserRequest;
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
    public function update(StoreAdminUserRequest $request, $uuid)
    {
        $validated = $request->validated();

        $password = Hash::make($validated['password']);
        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            return response()->json(['error' => ['message' => 'user not found']], 404);
        }
        $user->update(['uuid' => Str::uuid(), 'first_name' => $validated['first_name'], 'last_name' => $validated['last_name'], 'email' => $validated['email'], 'password' => $password, 'is_admin' => 0, 'email_verified_at' => Carbon::now(), 'avatar' => $validated['avatar'], 'address' => $validated['address'], 'phone_number' => $validated['phone_number'], 'is_marketing' => $validated['marketing'] ?? 0]);

        return response()->json(['message' => ['user updated successfully'], 'user' => $user], 202);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $user = User::where('uuid', $uuid)->delete();
        if (!$user) {
            return response()->json(['error' => ['message' => 'user not found']], 404);
        }
        return response()->json(['data' => 'user deleted'], 200);
    }

    /**
     * Authenticate specific admin user
     * @param \Illuminate\Http\Request  $request
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
    public function logout(Request $request)
    {
        if (AuthService::resolveUserLogout($request->bearerToken())) {
            return response()->json(['success' => 'Logged out successfully. Token is unset']);
        }
        return response()->json(['error' => 'Token not found'], 200);
    }
}
