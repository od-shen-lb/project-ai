<?php

use Illuminate\Support\Facades\Route;

Route::as('api.')->group(function () {
    Route::apiResource('tokens', 'TokenController', ['only' => ['store', 'destroy']]);
    Route::post('password:get-hashed', 'DemoController@store')->name('demo.store');

    Route::middleware(['auth'])->group(function () {
        Route::apiResource('me', 'MeController', ['only' => ['index']]);
    });
});
