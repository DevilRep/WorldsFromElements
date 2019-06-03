<?php

Route::namespace('API')->group(function () {
    Route::post('/login', 'Auth@login');
    Route::post('/signup', 'Auth@signup');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::resource('elements', 'AvailableElement')->only(['index', 'store']);
        Route::resource('game', 'Game')->only(['index', 'store']);
        Route::resource('users', 'User')->only(['show']);
    });
});
