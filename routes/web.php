<?php

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


/**
 * Default Controller
 */

Route::get('/',[\App\Http\Controllers\Client\Home\HomeController::class,'index'])->name('home');

Route::prefix('error')->group(function (){
   Route::get('404',[\App\Http\Controllers\Error\ErrorController::class,'errorNotFound'])->name('404');
});

/**
 * Client Controller
 */

Route::prefix('client')->group(function (){

    Route::prefix('category')->group(function (){
        Route::get('all-data',[\App\Http\Controllers\Client\Category\CategoryController::class,'allData'])->name('category-api');
        Route::get('/{keyword}',[\App\Http\Controllers\Client\Category\CategoryController::class,'index'])->name('category-index');
        Route::get('/find/{keyword}',[\App\Http\Controllers\Client\Category\CategoryController::class,'findCategoryProduct'])->name('find-category');
    });

    Route::prefix('payment')->group(function (){
        Route::get('/',[\App\Http\Controllers\Client\Payment\PaymentController::class,'index'])->name('payment-index');
    });

    Route::prefix('product')->group(function (){
        Route::get('all-data',[\App\Http\Controllers\Client\Product\ProductController::class,'allData'])->name('product-api');
        Route::get('/',[\App\Http\Controllers\Client\Product\ProductController::class,'index'])->name('product-index');
        Route::get('/{keyword}',[\App\Http\Controllers\Client\Product\ProductController::class,'singleProduct'])->name('single-product');
        Route::get('/mobile/{keyword}',[\App\Http\Controllers\Client\Product\ProductController::class,'dataMobile'])->name('search-data-mobile');
    });

    Route::prefix('search')->group(function (){
        Route::get('/{keyword}',[\App\Http\Controllers\Client\Search\SearchController::class,'index'])->name('search-index');
        Route::get('/all-data/{keyword}',[\App\Http\Controllers\Client\Search\SearchController::class,'allData'])->name('all-data-search');
    });

});

/**
 * Admin Controller
 */

Route::prefix('admin')->group(function (){

    Route::get('home',[\App\Http\Controllers\Admin\Home\HomeController::class,'index'])->name('admin-home');
    Route::get('category',[\App\Http\Controllers\Admin\Category\CategoryController::class,'index'])->name('admin-category');
    Route::get('product',[\App\Http\Controllers\Admin\Product\ProductController::class,'index'])->name('admin-product');
    Route::get('user',[\App\Http\Controllers\Admin\User\UserController::class,'index'])->name('admin-user');

    Route::prefix('auth')->group(function (){
       Route::get('login',[\App\Http\Controllers\Admin\Auth\AuthController::class,'index'])->name('index-login');
    });

});

