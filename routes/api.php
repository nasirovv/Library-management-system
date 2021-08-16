<?php

use App\Http\Controllers\Auth\LibrarianLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\AuthController;
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

Route::prefix('auth')->group(function (){
    Route::post('user/register', [RegisterController::class, 'register']);
    Route::post('user/login', [UserLoginController::class, 'login']);
    Route::post('librarian/login', [LibrarianLoginController::class, 'login']);
});


Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('auth:user')->prefix('user')->group(function () {
        Route::get('/', [UserLoginController::class, 'user']);
        Route::post('logout', [UserLoginController::class, 'logout']);
    });

    Route::middleware('auth:librarian')->prefix('librarian')->group(function () {
        Route::get('/', [LibrarianLoginController::class, 'librarian']);
        Route::post('logout', [LibrarianLoginController::class, 'logout']);
    });

});


