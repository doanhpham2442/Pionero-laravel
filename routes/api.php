<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('api')->group(function () {
//     Route::get('users', [UserController::class, 'index']);
//     Route::post('users', [UserController::class, 'store']);
//     Route::get('users/{id}', [UserController::class, 'show'])->where('id', '[0-9]+');
//     Route::put('users/{id}', [UserController::class, 'update'])->where('id', '[0-9]+');
//     Route::delete('users/{id}', [UserController::class, 'destroy'])->where('id', '[0-9]+');
// });
Route::middleware('api')->group(function () {
    Route::post('auth/register', [UserController::class, 'register']);
    Route::post('auth/login', [UserController::class, 'login']);
    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('user', [UserController::class, 'userInfo']);
    });
    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{id}', [UserController::class, 'show'])->where('id', '[0-9]+');
    Route::put('users/{id}', [UserController::class, 'update'])->where('id', '[0-9]+');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->where('id', '[0-9]+');
});

