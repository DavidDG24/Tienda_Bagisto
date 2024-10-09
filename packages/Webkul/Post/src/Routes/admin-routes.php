<?php

use Illuminate\Support\Facades\Route;
use Webkul\Post\Http\Controllers\Admin\PostController;

// packages/Webkul/Post/src/Routes/admin.php

use Webkul\Post\Http\Controllers\Admin\FacebookSettingsController;

Route::group(['prefix' => 'admin'], function () {
    Route::get('facebook-settings', [FacebookSettingsController::class, 'index'])->name('admin.facebook-settings.index');
    Route::put('facebook-settings', [FacebookSettingsController::class, 'update'])->name('admin.facebook-settings.update');
});


Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin/post'], function () {
    Route::controller(PostController::class)->group(function () {
        Route::get('', 'index')->name('admin.post.index');
    });
});