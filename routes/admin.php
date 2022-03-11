<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['permission:adminAccess']], function () {
    Route::resource('/products', \App\Http\Controllers\Admin\ProductsController::class)
        ->names('admin.products');
});
