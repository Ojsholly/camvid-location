<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\User\AuthController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->namespace('API/v1')->group(function () {

    Route::prefix('user')->namespace('User')->group(function () {
        Route::post('register', [AuthController::class, 'register']);

        Route::prefix('token')->middleware('auth:sanctum')->group(function () {

            Route::post('verify', [AuthController::class, 'verify']);
            Route::post('resend', [AuthController::class, 'resend']);
        });
    });
});