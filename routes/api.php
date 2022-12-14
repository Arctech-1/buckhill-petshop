<?php

// require '../vendor/autoload.php';

use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\User\UserController;
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

/* Non protect routes */

Route::middleware('acceptJson.api')->group(function () {
    Route::post('/v1/admin/login', [AdminController::class, 'login']);
    Route::post('/v1/user/login', [UserController::class, 'login']);

    Route::post('/v1/user/forgot-password', [UserController::class, 'forgotPassword']);
    Route::post('/v1/user/reset-password-token', [UserController::class, 'resetPassword']);
    Route::get('/v1/order', [OrderController::class,  'userOrders']);
    Route::get('/v1/order/{uuid}/download', [OrderController::class,  'downloadOrderInvoice']);


    /*
|--------------------------------------------------------------------------
| Protected API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
    Route::middleware('auth.api')->group(function () {

        Route::prefix('v1')->group(function () {
            /* Admin Routes */
            Route::middleware('roleAdmin.api')->group(function () {
                Route::prefix('admin')->group(function () {
                    Route::get('/user', function () {
                        return 'test url go through';
                    });
                    Route::post('/create', [AdminController::class, 'store']);
                    Route::put('/user-edit/{uuid}', [AdminController::class, 'update']);
                    Route::delete('/user-delete/{uuid}', [AdminController::class, 'destroy']);
                    Route::post('/logout', [AdminController::class, 'logout']);
                });
            });

            /* User Routes */
            Route::get('/user', [UserController::class, 'index']);
            Route::middleware('roleUser.api')->group(function () {
                Route::prefix('user')->group(function () {
                    Route::get('/check', function () {
                        return 'test url go through';
                    });
                    Route::post('/logout', [UserController::class, 'logout']);
                });
            });
        });
    });
});
