<?php

use App\Http\Controllers\API\AcceptanceApiController;
use App\Http\Controllers\API\SigneeApiController;
use App\Http\Controllers\API\UserApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'v1', 'middleware' => []], function () {
    Route::post('login', [UserApiController::class, 'loginUser']);
    Route::post('submit-weight', [AcceptanceApiController::class, 'postWeight']);
    Route::get('requirements', [AcceptanceApiController::class, 'getRequirements']);
    Route::get('acceptance', [AcceptanceApiController::class, 'index']);
    Route::post('acceptance-request', [AcceptanceApiController::class, 'acceptanceRequest']);
    

    Route::group(['prefix' => 'acceptance', 'middleware' => []], function () {
        Route::get('details/{id}', [AcceptanceApiController::class, 'acceptanceDetails']);
        Route::get('generatepdf/{id}', [AcceptanceApiController::class, 'generatePDF']);
    });
    Route::group(['prefix' => 'users', 'middleware' => []], function () {
        Route::get('', [UserApiController::class, 'index']);
        Route::post('store', [UserApiController::class, 'store']);
        Route::post('update', [UserApiController::class, 'update']);
    });
    Route::group(['prefix' => 'configurations', 'middleware' => []], function () {
        Route::get('', [AcceptanceApiController::class, 'configurations']);
    });
    Route::group(['prefix' => 'signees', 'middleware' => []], function () {
        Route::get('', [SigneeApiController::class, 'index']);
        Route::get('in', [SigneeApiController::class, 'indexapi']);
        Route::get('edit/{id}', [SigneeApiController::class, 'edit']);
        Route::post('store', [SigneeApiController::class, 'store']);
        Route::post('update', [SigneeApiController::class, 'update']);
    });
});
