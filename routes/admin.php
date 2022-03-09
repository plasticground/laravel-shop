<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['permission:adminAccess']], function () {
    //
});
