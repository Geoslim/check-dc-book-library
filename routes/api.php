<?php

use App\Http\Controllers\API\BorrowController;
use App\Http\Controllers\API\Admin\{BookController, LendingController, PlanController, UserController};
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

Route::middleware(['auth:sanctum', 'verify.profile'])->group(function () {
    Route::controller(SubscriptionController::class)
        ->prefix('subscriptions')->group(function () {
            Route::get('', 'index');
            Route::post('', 'subscribe');
            Route::get('active', 'activeSubscription');
            Route::post('unsubscribe', 'unsubscribe');
        });

    Route::controller(BorrowController::class)->group(function () {
        Route::get('borrowed-books', 'borrowedBooks');
        Route::get('active-borrowed-books', 'activeBorrowedBooks');
        Route::get('returned-books', 'returnedBooks');
        Route::post('borrow-book', 'borrowBook');
    });
});

Route::prefix('admin')->middleware([
    'auth:sanctum',
    'role:admin',
    'verify.profile'
])->group(function () {
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

    Route::controller(LendingController::class)->prefix('lendings')->group(function () {
        Route::get('', 'getLendings');
        Route::post('', 'createLending');
        Route::prefix('{lending}')->group(function () {
            Route::get('', 'getLending');
            Route::post('status', 'markLendingAsReturned');
            Route::post('update', 'updateLending');
            Route::delete('delete', 'deleteLending');
        });
    });
});


/**
 * Note to self
 * --------------------------------
 * Profile needs to be updated with at least the age in order to borrow a book
 * Age is used in getting a user's access level
 *
 * A user must be subscribed before they can also borrow a book
 * Probably add a middleware to make sure you cannot attempt borrowing if you're not subscribed
 *
 * Best way to manage lendings will be to have a book count i.e each book has copies
 * and the count reduces or increases when borrowed or returned
 *
 * Ensure you go over the migration files again... probably for soft delete or
 * cascading or even indexing
 */
