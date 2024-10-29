<?php

use Illuminate\Support\Facades\Route;
use Webkul\Post\Http\Controllers\Admin\PostController;

// packages/Webkul/Post/src/Routes/admin.php

use Webkul\Post\Http\Controllers\Admin\FacebookSettingsController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin'], function () {
    // Ruta para la configuración de Facebook
    Route::get('facebook-post', [FacebookSettingsController::class, 'index'])->name('admin.post.facebook-post.index');
    Route::put('facebook-post', [FacebookSettingsController::class, 'updatePost'])->name('admin.facebook-post.update');

    Route::get('facebook-video', [FacebookSettingsController::class, 'video'])->name('admin.post.facebook-video.index');
    Route::post('facebook-video', [FacebookSettingsController::class, 'upVideo'])->name('admin.facebook-video.up');

    // Ruta para las publicaciones
    Route::get('post', [PostController::class, 'index'])->name('admin.post.index');
});