<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LibrarianController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AdminLoginController;
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
    Route::post('admin/login', [AdminLoginController::class, 'login']);
});


Route::middleware('auth:sanctum')->group(function () {

    // Routes for auth
    Route::middleware('auth:user')->prefix('user')->group(function () {
        Route::get('/', [UserLoginController::class, 'user']);
        Route::post('logout', [UserLoginController::class, 'logout']);
    });

    Route::middleware('auth:librarian')->prefix('librarian')->group(function () {
        Route::get('/', [LibrarianLoginController::class, 'librarian']);
        Route::post('logout', [LibrarianLoginController::class, 'logout']);
    });

    Route::middleware('auth:admin')->prefix('admin')->group(function () {
        Route::get('/', [AdminLoginController::class, 'admin']);
        Route::post('logout', [AdminLoginController::class, 'logout']);
    });




    // Routes
    Route::middleware('auth:user')->prefix('user')->group(function () {

    });

    Route::middleware('auth:librarian')->prefix('librarian')->group(function () {
        // TODO duplicate route need to fix
        Route::get('users', [UserController::class, 'index']);
    });

    Route::middleware('auth:admin')->prefix('admin')->group(function () {
        Route::patch('edit', [AdminLoginController::class, 'edit']);

        // Users crud
        // TODO duplicate route need to fix
        Route::get('users', [UserController::class, 'index']);
        // Librarians crud
        Route::apiResource('librarians', LibrarianController::class)->except('update');
        Route::post('librarians/{id}', [LibrarianController::class, 'update']);
        // Categories crud
        Route::apiResource('categories', CategoryController::class)->except('index');
        // Books crud
        Route::apiResource('books', BookController::class)->except('update');
        Route::post('books/{id}', [BookController::class, 'update']);


        Route::apiResources([

        ]);
    });

    // For all guards
    Route::get('categories', [CategoryController::class, 'index']);

    Route::get('verifyToken', [RegisterController::class, 'token']);
});


