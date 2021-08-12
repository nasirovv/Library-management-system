<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
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

Route::post('register', [RegisterController::class, 'register']);


Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('auth:user')->group(function () {

    });

    Route::middleware('auth:librarian')->group(function () {
        Route::get('/aa', function (){
            return 1;
        });
    });
});


