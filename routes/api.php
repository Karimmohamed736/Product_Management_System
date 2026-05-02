<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\Products\ProductsAttributesController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function(){
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::middleware('auth:api')->controller(AuthController::class)->group(function(){
    Route::post('/logout', 'logout');
    Route::get('/profile', 'profile');
});

Route::middleware('auth:api')->controller(CategoryController::class)->group(function(){
    Route::get('/categories/tree', 'catTree');
    Route::get('/categories', 'getAllCategories');
    Route::post('create/category', 'createCategory');
    Route::get('show/category/{category}', 'show');
    Route::put('update/category/{category}', 'update');
    Route::delete('delete/category/{category}', 'destroy');
});

Route::middleware('auth:api')->controller(ProductController::class)->group(function(){
    Route::post('/create/product', 'createProduct');
    Route::put('/update/product/{product}', 'update');
    Route::delete('/delete/product/{product}', 'destroy');
});

Route::controller(ProductController::class)->group(function(){
    Route::get('/products', 'getAllProducts');
    Route::get('/show/product/{product}', 'show');
});


Route::controller(ProductsAttributesController::class)->group(function(){
    Route::get('/attributes', 'getAllAttributes');
    Route::post('/create/attribute', 'createAttribute')->middleware('auth:api');
});
