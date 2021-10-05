<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {

    // Public route
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // Private route
    Route::middleware('auth:api')->group(function () {
        Route::get('posts', [PostController::class, 'getAll']);
        Route::get('post/{id}', [PostController::class, 'getById']);
        Route::post('post', [PostController::class, 'save']);
        Route::put('post/{id}', [PostController::class, 'update']);
        Route::delete('post/{id}', [PostController::class, 'delete']);

        Route::post('logout', [AuthController::class, 'logout']);
    });
});
