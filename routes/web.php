<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('users/{id?}', function ($id = null) {
    if (isset($id)) {
        return app(UserController::class)->show($id);
    } else {
        return app(UserController::class)->index();
    }
})->where('id', '[0-9]+')->name('users.index');;

Route::get('users/create', [UserController::class, 'create']);
Route::post('users/store', [UserController::class, 'store']);
Route::get('users/edit/{id}', [UserController::class, 'edit'])->where('id', '[0-9]+');
Route::post('users/update/{id}', [UserController::class, 'update'])->where('id', '[0-9]+');
Route::get('users/delete/{id}', [UserController::class, 'delete'])->where('id', '[0-9]+');



