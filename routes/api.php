<?php

use App\Http\Controllers\Api\PokemonController;
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

Route::middleware('json.response')->group(function () {

    //Register
    Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);

    // Login
    Route::post('/login_check', [App\Http\Controllers\Api\AuthController::class, 'login']);

    // Logout
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:api');

    Route::apiResource('pokemon', PokemonController::class)->middleware('auth:api');
});
