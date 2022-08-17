<?php

// require '../vendor/autoload.php';

use App\Models\User;
use App\Services\JwtService;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Lcobucci\JWT\Signer\Hmac\Sha256;





/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */


Route::middleware('auth.api')->group(function () {

    Route::prefix('v1')->group(function () {
        /* Admin Routes */
        Route::middleware('role.api')->group(function () {
            Route::prefix('admin')->group(function () {
                Route::get('/user', function (Request $request) {
                    return response()->json(['data' => 'welcome to admin route']);
                })->name('admin.users');
            });
        });


        /* User Routes */
        Route::prefix('user')->group(function () {
            Route::get('/home', function (Request $request) {
                return response()->json(['data' => 'welcome of user homepage']);
            });
        });


        Route::get('/check-token', function () {
            $tokenServ = new JwtService(env('JWT_PUBLIC_KEY'));
            $token = $tokenServ->checkIfTokenIsExpired(env("JWT_TOKEN"));
            if (!$token) {
                return response()->json(['data' => 'token not found']);
            }
            return response()->json(['data' => $token]);
        });
    });
});
