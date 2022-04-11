<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['permission:adminAccess']], function () {
    Route::resource('/products', \App\Http\Controllers\Admin\ProductsController::class)
        ->names('admin.products');

    Route::resource('/orders', \App\Http\Controllers\Admin\OrderController::class)
        ->only(['index', 'show'])
        ->names('admin.orders');

    Route::group(['prefix' => 'orders', 'as' => 'admin.orders.'], function () {
        Route::post('approve/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'approve'])->name('approve');
        Route::post('reject/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'reject'])->name('reject');
    });

    Route::get('/statistics', \App\Http\Controllers\admin\StatisticsController::class)
        ->name('admin.statistics.index');
});
