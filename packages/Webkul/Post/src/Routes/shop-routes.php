<?php

use Illuminate\Support\Facades\Route;
use Webkul\Post\Http\Controllers\Shop\PostController;

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency'], 'prefix' => 'post'], function () {
    Route::get('', [PostController::class, 'index'])->name('shop.post.index');
});