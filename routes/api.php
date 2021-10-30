<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LibrarianController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\LibrarianLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Librarian\UserController as LibrarianUserController;
use App\Http\Controllers\Librarian\OrderController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\User\UserController as UserUserController;
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


    // TODO The routes at the top are awesome
    // TODO The routes at the bottom need fix

    // Routes
    Route::middleware('auth:user')->prefix('user')->group(function () {
        Route::post('order', [UserOrderController::class, 'order']);
        Route::get('orders', [UserOrderController::class, 'index']);
        Route::get('librarians/{librarian}', [UserUserController::class, 'showLibrarian']);
        Route::put('edit', [UserUserController::class, 'edit']);
        Route::put('edit', [UserUserController::class, 'editPassword']);
        Route::patch('return-book', [UserUserController::class, 'returnBook']);
    });

    Route::middleware('auth:librarian')->prefix('librarian')->group(function () {
        Route::post('users/block/{id}', [LibrarianUserController::class, 'block']);
        Route::post('users/unblock/{id}', [LibrarianUserController::class, 'unblock']);
        Route::post('order/accept/{id}', [OrderController::class, 'acceptOrder']);
        Route::post('order/reject/{id}', [OrderController::class, 'rejectOrder']);
        Route::get('applications', [OrderController::class, 'applications']);
        Route::get('orders', [OrderController::class, 'orders']);

    });

    Route::middleware('auth:admin')->prefix('admin')->group(function () {
        Route::patch('/', [AdminLoginController::class, 'edit']);

        Route::get('orders', [AdminOrderController::class, 'index']);

        // Users crud
        Route::delete('users/{id}', [UserController::class, 'delete']);
        // Librarians crud
        Route::apiResource('librarians', LibrarianController::class)->except('update');
        Route::post('librarians/{id}', [LibrarianController::class, 'update']);
        // Categories crud
        Route::apiResource('categories', CategoryController::class)->except('index');
        // Books crud
        Route::apiResource('books', BookController::class)->except(['index', 'update', 'show']);
        Route::post('books/{id}', [BookController::class, 'update']);

    });

    Route::middleware(['auth:admin,librarian'])->group(function () {
        Route::get('users', [UserController::class, 'index']);
        Route::get('users/{id}', [UserController::class, 'show']);
    });

    // For all guards
    Route::get('verifyToken', [RegisterController::class, 'token']);
});


Route::get('categories', [CategoryController::class, 'index']);
Route::get('books', [BookController::class, 'index']);
Route::get('books/{id}', [BookController::class, 'show']);



