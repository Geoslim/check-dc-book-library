<?php

use App\Http\Controllers\API\BorrowController;
use App\Http\Controllers\API\Admin\{
    BookController,
    PlanController,
    UserController
};
use App\Http\Controllers\API\Auth\{AuthController, ProfileController};
use App\Http\Controllers\API\SubscriptionController;
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

Route::get('/', function () {
    return ['message' => 'Check DC Book Library API'];
});

Route::prefix('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::post('logout', 'logout')
            ->middleware('auth:sanctum');
    });

    Route::post('profile/update', ProfileController::class)
        ->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('subscriptions', SubscriptionController::class); // change this

    Route::controller(BorrowController::class)->group(function () {
        Route::get('borrowed-books', 'borrowedBooks');
        Route::get('returned-books', 'returnedBooks');
        Route::post('borrow-book', 'borrowBook');
    });
});

Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::controller(PlanController::class)->prefix('plans')->group(function () {
        Route::get('', 'getPlans');
        Route::post('', 'createPlan');
        Route::prefix('{plan}')->group(function () {
            Route::get('', 'getPlan');
            Route::post('update', 'updatePlan');
            Route::delete('delete', 'deletePlan');
        });
    });

    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('', 'getUsers');
        Route::post('', 'createUser');
        Route::prefix('{user}')->group(function () {
            Route::get('', 'getUser');
            Route::post('status', 'updateStatus');
            Route::post('update', 'updateUser');
            Route::delete('delete', 'deleteUser');
        });
    });

    Route::controller(BookController::class)->prefix('books')->group(function () {
        Route::get('', 'getBooks');
        Route::post('', 'createBook');
        Route::prefix('{book}')->group(function () {
            Route::get('', 'getBook');
            Route::post('status', 'updateBookStatus');
            Route::post('update', 'updateBook');
            Route::delete('delete', 'deleteBook');
        });
    });
});
