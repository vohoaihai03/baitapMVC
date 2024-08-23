<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;


// products
// Route::post('products', [ProductController::class, 'store']);
// Route::get('products', [ProductController::class, 'index']);
// Route::put('products/{id}', [ProductController::class, 'update']);
// Route::get('products/{id}', [ProductController::class, 'show']);
// Route::delete('products/{id}', [ProductController::class, 'destroy']);

Route::apiResource('products', ProductController::class);

Route::apiResource('customers', CustomerController::class);
