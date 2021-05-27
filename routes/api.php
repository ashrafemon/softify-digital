<?php

use App\Http\Controllers\Api\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Api\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Client\CartController;
use App\Http\Controllers\Api\Client\CategoryController;
use App\Http\Controllers\Api\Client\OrderController;
use App\Http\Controllers\Api\Client\ProductController;
use App\Http\Controllers\Api\ProfileController;
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

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{slug}', [ProductController::class, 'show']);
Route::get('products/items/new_arrivals', [ProductController::class, 'new_arrivals']);

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{slug}', [CategoryController::class, 'show']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('carts', CartController::class);

    Route::patch('orders/{id}/cancel', [OrderController::class, 'cancel_order']);
    Route::apiResource('orders', OrderController::class);
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

Route::prefix('admin')->middleware(['auth:sanctum', 'admin.checker'])->group(function () {
    Route::apiResource('users', AdminUserController::class);
    Route::apiResource('categories', AdminCategoryController::class);
    Route::apiResource('products', AdminProductController::class);
    Route::apiResource('orders', AdminOrderController::class);
});


