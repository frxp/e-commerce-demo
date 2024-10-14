<?php

declare(strict_types=1);

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/products/{id}/purchase', [ProductController::class, 'purchase']);
Route::post('/products/purchase', [ProductController::class, 'cartPurchase']);
