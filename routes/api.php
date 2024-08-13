<?php

use App\Http\Controllers\Api\WastetypeController;
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
    Route::get('/wastetypes', [WastetypeController::class, 'index'])->name('wastetypes.index');
    Route::post('/wastetypes', [WastetypeController::class, 'store'])->name('wastetypes.store');
    Route::get('/wastetypes/{id}', [WastetypeController::class, 'show'])->name('wastetypes.show');
    Route::put('/wastetypes/{id}', [WastetypeController::class, 'update'])->name('wastetypes.update');
    Route::delete('/wastetypes/{id}', [WastetypeController::class, 'destroy'])->name('wastetypes.destroy');
});
