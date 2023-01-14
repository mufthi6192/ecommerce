<?php

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

Route::prefix('auth')->group(function (){
    Route::post('login',[\App\Http\Controllers\Admin\Auth\AuthController::class,'login'])->name('api-login');
    Route::get('logout',[\App\Http\Controllers\Admin\Auth\AuthController::class,'logout'])->middleware('auth:api')->name('api-logout');
});

Route::prefix('admin')->group(function (){

    Route::prefix('home')->middleware('auth:api')->group(function (){
       Route::get('/',[\App\Http\Controllers\Admin\Home\HomeController::class,'allHome'])->name('api-data-home');
    });

    Route::prefix('profile')->middleware('auth:api')->group(function (){
        Route::get('/',[\App\Http\Controllers\Admin\Profile\ProfileController::class,'userProfile'])->name('api-data-profile');
    });

    Route::prefix('notification')->middleware('auth:api')->group(function (){
        Route::get('/',[\App\Http\Controllers\Admin\Notification\NotificationController::class,'allNotification'])->name('api-data-notification');
    });

    Route::prefix('category')->middleware('auth:api')->group(function (){
       Route::get('/',[\App\Http\Controllers\Admin\Category\CategoryController::class,'allCategory'])->name('api-all-category');
       Route::get('/{idCategory}',[\App\Http\Controllers\Admin\Category\CategoryController::class,'detailCategory'])->name('api-detail-category');
       Route::post('add',[\App\Http\Controllers\Admin\Category\CategoryController::class,'addCategory'])->name('api-add-category');
       Route::post('update/{idCategory}',[\App\Http\Controllers\Admin\Category\CategoryController::class,'updateCategory'])->name('api-update-category');
       Route::delete('delete/{idCategory}',[\App\Http\Controllers\Admin\Category\CategoryController::class,'deleteCategory'])->name('api-delete-category');
    });

    Route::prefix('product')->middleware('auth:api')->group(function (){
        Route::get('/',[\App\Http\Controllers\Admin\Product\ProductController::class,'allProduct'])->name('api-all-product');
        Route::get('/{idProduct}',[\App\Http\Controllers\Admin\Product\ProductController::class,'detailProduct'])->name('api-detail-product');
        Route::post('add',[\App\Http\Controllers\Admin\Product\ProductController::class,'addProduct'])->name('api-add-product');
        Route::post('add/{idProduct}',[\App\Http\Controllers\Admin\Product\ProductController::class,'addImageProduct'])->name('api-add-image-product');
        Route::delete('delete/{idProduct}',[\App\Http\Controllers\Admin\Product\ProductController::class,'deleteProduct'])->name('api-delete-product');
        Route::post('update/{idProduct}',[\App\Http\Controllers\Admin\Product\ProductController::class,'updateProduct'])->name('api-update-product');
        Route::get('image/{idImage}',[\App\Http\Controllers\Admin\Product\ProductController::class,'allImageProduct'])->name('api-detail-image-product');
    });

    Route::prefix('user')->middleware('auth:api')->group(function (){
       Route::get('/',[\App\Http\Controllers\Admin\User\UserController::class,'allUser'])->name('api-all-user');
       Route::get('/{idUser}',[\App\Http\Controllers\Admin\User\UserController::class,'detailUser'])->name('api-detail-user');
       Route::post('add',[\App\Http\Controllers\Admin\User\UserController::class,'insertUser'])->name('api-add-user');
       Route::delete('delete/{idUser}',[\App\Http\Controllers\Admin\User\UserController::class,'deleteUser'])->name('api-delete-user');
    });
});
