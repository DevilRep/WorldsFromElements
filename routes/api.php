<?php

Route::namespace('API')->group(function () {
    Route::post('/login', 'Auth@login');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::resource('elements', 'AvailableElements')->only(['index', 'store']);
        Route::resource('game', 'Game')->only(['index', 'store']);
    });
});
