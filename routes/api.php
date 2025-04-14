<?php

use App\Http\Controllers\RecipeController;
use App\Http\Middleware\AuthDeviceMiddleware;

Route::controller(RecipeController::class)
    ->prefix('recipes')
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{recipe}', 'show');

        Route::middleware(AuthDeviceMiddleware::class)
            ->group(static function () {
                Route::post('/{recipes}/likes', 'likes');
                Route::post('/{recipe}/like', 'like');
                Route::delete('/{recipe}/dislike', 'dislike');
            });
    });
