<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ColorsController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UsersController;
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

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('profile', 'GetProfile')->name('GetProfile');
});

Route::controller(UsersController::class)->prefix('users')->group(function () {
    Route::post('new', 'NewUser')->name('NewUser');
});

Route::controller(ColorsController::class)->prefix('colors')->group(function () {
    Route::post('new', 'NewColor')->name('NewColor');
    Route::put('update', 'UpdateColor')->name('UpdateColor');
    Route::post('where', 'GetColors')->name('GetColors');
});

Route::controller(TagsController::class)->prefix('tags')->group(function () {
    Route::get('show/{id}', 'ShowTag')->whereNumber('id')->name('ShowTag');
    Route::delete('delete/{id}', 'DeleteTag')->whereNumber('id')->name('DeleteTag');
    Route::post('where', 'GetTags')->name('GetTags');
    Route::post('new', 'NewTag')->name('NewTag');
    Route::put('update', 'UpdateTag')->name('UpdateTag');
});

