<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutoRegisterController;


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
Route::post('autoRes', [AutoRegisterController::class, 'index']);
Route::get('autoRes2/{email}/{password}', [AutoRegisterController::class, 'show']);
Route::post('autoRes3/', [AutoRegisterController::class, 'store']);

Route::get('guestLogin/{token}', [AutoRegisterController::class, 'guestLogin']);
Route::post('guestSignUp/', [AutoRegisterController::class, 'guestSignUp']);
Route::get('testPage', [AutoRegisterController::class, 'test']);
Route::post('ssoPromocion', [AutoRegisterController::class, 'ssoPromocion']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
