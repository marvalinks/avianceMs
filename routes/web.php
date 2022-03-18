<?php

use App\Http\Controllers\AcceptanceModuleController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\UserModuleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('login', [AuthenticationController::class, 'login'])->name('login');
Route::post('login', [AuthenticationController::class, 'postLogin'])->name('login');

Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');

Route::group(['prefix' => '', 'as' => 'backend.', 'middleware' => ['auth']], function () {
    Route::get('dahboard', [BackendController::class, 'dashboard'])->name('dashboard');

    Route::group(['prefix' => 'acceptance', 'as' => 'acceptance.', 'middleware' => []], function () {
        Route::get('', [AcceptanceModuleController::class, 'index'])->name('list');
        Route::get('details/{id}', [AcceptanceModuleController::class, 'show'])->name('details');
        Route::get('create', [AcceptanceModuleController::class, 'create'])->name('create');
        Route::post('create', [AcceptanceModuleController::class, 'submitForms'])->name('create');
        Route::get('edit', [AcceptanceModuleController::class, 'edit'])->name('edit');
    });

    Route::group(['prefix' => 'users', 'as' => 'users.', 'middleware' => ['adminAccess']], function () {
        Route::get('', [UserModuleController::class, 'index'])->name('list');
        Route::get('create', [UserModuleController::class, 'create'])->name('create');
        Route::post('create', [UserModuleController::class, 'store'])->name('create');
        Route::get('edit/{id}', [UserModuleController::class, 'edit'])->name('edit');
        Route::post('edit/{id}', [UserModuleController::class, 'update'])->name('edit');
    });
});
