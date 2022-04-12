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

Route::get('/', \App\Http\Controllers\Web\IndexController::class)->name('index');

Route::resource('/products', \App\Http\Controllers\Web\ProductsController::class)
    ->only(['index', 'show'])
    ->names('web.products');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['prefix' => 'cart', 'as' => 'web.cart.'], function () {
    Route::get('/', [\App\Http\Controllers\Web\CartController::class, 'index'])->name('index');
    Route::put('item/{id}', [\App\Http\Controllers\Web\CartController::class, 'addItem'])->name('add');
    Route::delete('item/{id}', [\App\Http\Controllers\Web\CartController::class, 'removeItem'])->name('remove');
});

Route::resource('/orders', \App\Http\Controllers\Web\OrderController::class)
    ->except(['edit', 'update', 'destroy'])
    ->names('web.orders');

require __DIR__.'/auth.php';
