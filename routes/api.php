<?php

use App\Http\Controllers\Admin\Families\FamiliesController;
use App\Http\Controllers\Admin\Families\FamilyAttributesController;
use App\Http\Controllers\Admin\Products\AdminProductsController;
use App\Http\Controllers\Admin\Providers\ProvidersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ColorsController;
use App\Http\Controllers\Store\Products\StoreProductsController;
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

Route::prefix('store')->group(function () {
    Route::controller(StoreProductsController::class)->prefix('products')->group(function () {
        Route::get('/', 'GetProducts')->name('StoreGetProducts');
        Route::get('/{id}', 'ProductDetails')->whereNumber('id')->name('StoreProductDetails');

    });
});

Route::prefix('admin')->group(function () {
    Route::controller(UsersController::class)->prefix('users')->group(function () {
        Route::post('/', 'NewUser')->name('NewUser');
    });

    Route::controller(FamiliesController::class)->prefix('families')->group(function () {
        Route::get('/', 'WhereFamilies')->name('WhereFamilies');
        Route::get('/{id}', 'ShowFamily')->whereNumber('id')->name('ShowFamily');
        Route::post('new', 'NewFamily')->name('NewFamily');
        Route::put('/{id}', 'UpdateFamily')->name('UpdateFamily');

        Route::get('{id}/attributes', 'GetFamilyAttributes')->name('GetFamilyAttributes');
    });

    Route::controller(FamilyAttributesController::class)->prefix('families/attributes')->group(function () {
        Route::post('new', 'NewAttribute')->name('NewAttribute');
        Route::put('update', 'UpdateAttribute')->name('UpdateAttribute');
    });

    Route::controller(ColorsController::class)->prefix('colors')->group(function () {
        Route::get('/{id}', 'ShowColor')->whereNumber('id')->name('ShowColor');
        Route::post('/', 'NewColor')->name('NewColor');
        Route::put('update', 'UpdateColor')->name('UpdateColor');
        Route::get('/', 'WhereColors')->name('WhereColors');
    });

    Route::controller(TagsController::class)->prefix('tags')->group(function () {
        Route::get('/{id}', 'ShowTag')->whereNumber('id')->name('ShowTag');
        Route::delete('/{id}', 'DeleteTag')->whereNumber('id')->name('DeleteTag');
        Route::get('/', 'WhereTags')->name('WhereTags');
        Route::post('/', 'NewTag')->name('NewTag');
        Route::put('/{id}', 'UpdateTag')->whereNumber('id')->name('UpdateTag');
    });

    Route::controller(ProvidersController::class)->prefix('providers')->group(function () {
        Route::get('/', 'WhereProviders')->name('WhereProviders');
    });

    Route::controller(AdminProductsController::class)->prefix('products')->group(function () {
        Route::get('/', 'WhereProducts')->name('WhereProducts');
        Route::get('/{id}', 'ShowProduct')->whereNumber('id')->name('ShowProduct');
        Route::post('/', 'NewProduct')->name('NewProduct');
    });
});

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('profile', 'GetProfile')->name('GetProfile');
});

