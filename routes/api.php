<?php

Route::namespace('API')->group(function () {
    Route::post('user/login', 'User@login');
    Route::post('user/signup', 'User@signup');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::resource('elements', 'AvailableElement')->only(['index', 'store']);
        Route::resource('game', 'Game')->only(['index', 'store']);

        Route::get('user/info', 'User@info');
        Route::post('user/logout', 'User@logout');
    });
});
