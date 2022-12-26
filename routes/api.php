<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('login', 'App\Http\Controllers\Api\v1\AuthController@login');
    Route::post('register', 'App\Http\Controllers\Api\v1\AuthController@register');

    // Forget Password Api
    Route::post('password/email', App\Http\Controllers\Api\v1\PasswordReset\ForgetPasswordController::class);
    Route::post('password/code/check', App\Http\Controllers\Api\v1\PasswordReset\CodeCheckController::class);
    Route::post('password/reset', App\Http\Controllers\Api\v1\PasswordReset\ResetPasswordController::class);


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', 'App\Http\Controllers\Api\v1\AuthController@logout');
    });
});
