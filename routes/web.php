<?php

use App\Http\Controllers\AcceptanceModuleController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\SigneeController;
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
Route::get('weight-scale', [AcceptanceModuleController::class, 'scale'])->name('wscale');
Route::get('login', [AuthenticationController::class, 'login'])->name('login');
Route::post('login', [AuthenticationController::class, 'postLogin'])->name('login');

Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');

if(env('APP_ENV') == 'production') {
    Route::group(['prefix' => '', 'as' => 'backend.', 'middleware' => ['auth']], function () {
        Route::get('dahboard', [BackendController::class, 'dashboard'])->name('dashboard');
    
        Route::group(['prefix' => 'acceptance', 'as' => 'acceptance.', 'middleware' => []], function () {
            Route::get('', [AcceptanceModuleController::class, 'index'])->name('list');
            Route::get('details/{id}', [AcceptanceModuleController::class, 'show'])->name('details');
            Route::get('create', [AcceptanceModuleController::class, 'create'])->name('create');
            Route::post('create', [AcceptanceModuleController::class, 'submitForms'])->name('create');
            Route::get('edit', [AcceptanceModuleController::class, 'edit'])->name('edit');
            Route::get('export', [AcceptanceModuleController::class, 'export'])->name('export');
            
        });
    
        Route::group(['prefix' => 'users', 'as' => 'users.', 'middleware' => ['adminAccess']], function () {
            Route::get('', [UserModuleController::class, 'index'])->name('list');
            Route::get('create', [UserModuleController::class, 'create'])->name('create');
            Route::post('create', [UserModuleController::class, 'store'])->name('create');
            Route::get('edit/{id}', [UserModuleController::class, 'edit'])->name('edit');
            Route::post('edit/{id}', [UserModuleController::class, 'update'])->name('edit');
        });
    
        Route::group(['prefix' => 'signees', 'as' => 'signees.', 'middleware' => ['adminAccess']], function () {
            Route::get('', [SigneeController::class, 'index'])->name('list');
            Route::get('create', [SigneeController::class, 'create'])->name('create');
            Route::post('create', [SigneeController::class, 'store'])->name('create');
            Route::get('edit/{id}', [SigneeController::class, 'edit'])->name('edit');
            Route::post('edit/{id}', [SigneeController::class, 'update'])->name('edit');
        });
    });
}else{
    Route::group(['prefix' => '', 'as' => 'backend.', 'middleware' => ['sessionGrant']], function () {
        Route::get('dahboard', [BackendController::class, 'dashboard'])->name('dashboard');
    
        Route::group(['prefix' => 'acceptance', 'as' => 'acceptance.', 'middleware' => []], function () {
            Route::get('', [AcceptanceModuleController::class, 'index'])->name('list');
            Route::get('details/{id}', [AcceptanceModuleController::class, 'show'])->name('details');
            Route::get('create', [AcceptanceModuleController::class, 'create'])->name('create');
            Route::post('create', [AcceptanceModuleController::class, 'submitForms'])->name('create');
            Route::get('edit', [AcceptanceModuleController::class, 'edit'])->name('edit');
            Route::get('export', [AcceptanceModuleController::class, 'export'])->name('export');
            Route::get('generate-pdf/{id}', [AcceptanceModuleController::class, 'generatePDF'])->name('generate.pdf');
        });
    
        Route::group(['prefix' => 'users', 'as' => 'users.', 'middleware' => ['adminAccess']], function () {
            Route::get('', [UserModuleController::class, 'index'])->name('list');
            Route::get('create', [UserModuleController::class, 'create'])->name('create');
            Route::post('create', [UserModuleController::class, 'store'])->name('create');
            Route::get('edit/{id}', [UserModuleController::class, 'edit'])->name('edit');
            Route::post('edit/{id}', [UserModuleController::class, 'update'])->name('edit');
        });
    
        Route::group(['prefix' => 'signees', 'as' => 'signees.', 'middleware' => ['adminAccess']], function () {
            Route::get('', [SigneeController::class, 'index'])->name('list');
            Route::get('create', [SigneeController::class, 'create'])->name('create');
            Route::post('create', [SigneeController::class, 'store'])->name('create');
            Route::get('edit/{id}', [SigneeController::class, 'edit'])->name('edit');
            Route::post('edit/{id}', [SigneeController::class, 'update'])->name('edit');
        });

        Route::group(['prefix' => 'configurations', 'as' => 'configurations.', 'middleware' => ['adminAccess']], function () {
            Route::get('', [ConfigurationController::class, 'index'])->name('index');
            Route::post('', [ConfigurationController::class, 'create'])->name('create');
        });
    });
}


