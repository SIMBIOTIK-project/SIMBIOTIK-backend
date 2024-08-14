<?php

use App\Http\Controllers\Api\DepositController;
use App\Http\Controllers\Api\WastetypeController;
use App\Http\Controllers\Api\WithDrawalController;
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

/**
 * route "/register"
 * @method "POST"
 */
Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');

/**
 * route "/login"
 * @method "POST"
 */
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');

/**
 * route "/logout"
 * @method "POST"
 */
Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');

/**
 * route "/user"
 * @method "GET"
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * route
 * @method "GET"
 */
Route::middleware('auth:api')->group(function () {
    // Waste Type
    Route::get('/wastetypes', [WastetypeController::class, 'index'])->name('wastetypes.index');
    Route::post('/wastetypes', [WastetypeController::class, 'store'])->name('wastetypes.store');
    Route::get('/wastetypes/{id}', [WastetypeController::class, 'show'])->name('wastetypes.show');
    Route::put('/wastetypes/{id}', [WastetypeController::class, 'update'])->name('wastetypes.update');
    Route::delete('/wastetypes/{id}', [WastetypeController::class, 'destroy'])->name('wastetypes.destroy');

    // Deposit
    Route::get('/deposits', [DepositController::class, 'index'])->name('deposits.index');
    Route::post('/deposits', [DepositController::class, 'store'])->name('deposits.store');
    Route::get('/deposits/{id}', [DepositController::class, 'show'])->name('deposits.show');
    Route::put('/deposits/{id}', [DepositController::class, 'update'])->name('deposits.update');
    Route::delete('/deposits/{id}', [DepositController::class, 'destroy'])->name('deposits.destroy');

    // Withdrawal
    Route::get('/withdrawals', [WithDrawalController::class, 'index'])->name('withdrawals.index');
    Route::post('/withdrawals', [WithDrawalController::class, 'store'])->name('withdrawals.store');
    Route::get('/withdrawals/{id}', [WithDrawalController::class, 'show'])->name('withdrawals.show');
    Route::put('/withdrawals/{id}', [WithDrawalController::class, 'update'])->name('withdrawals.update');
    Route::delete('/withdrawals/{id}', [WithDrawalController::class, 'destroy'])->name('withdrawals.destroy');
});
