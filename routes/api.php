<?php

use Illuminate\Http\Request;

Route::namespace('API')->group(function () {
    Route::resource('elements', 'AvailableElements')->only(['index', 'store']);
    Route::resource('game', 'Game')->only(['index', 'store']);
});