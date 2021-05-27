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

Route::view('/', 'client.home.index')->name('home');
Route::view('/carts', 'client.carts.index')->name('carts');
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

Route::prefix('admin')->group(function () {
    Route::view('/', 'admin.dashboard.index')->name('admin.dashboard.index');

    Route::view('/categories', 'admin.categories.index')->name('admin.categories.index');
    Route::view('/categories/create', 'admin.categories.create')->name('admin.categories.create');

    Route::view('/products', 'admin.products.index')->name('admin.products.index');
    Route::view('/products/create', 'admin.products.create')->name('admin.products.create');

    Route::view('/orders', 'admin.orders.index')->name('admin.orders.index');
    Route::view('/users', 'admin.users.index')->name('admin.users.index');
});
