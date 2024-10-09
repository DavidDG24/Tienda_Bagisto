<?php

use Illuminate\Support\Facades\Route;
use Webkul\Post\Http\Controllers\Admin\PostController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin/post'], function () {
    Route::controller(PostController::class)->group(function () {
        Route::get('', 'index')->name('admin.post.index');
    });
});