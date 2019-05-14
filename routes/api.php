<?php

Route::namespace('API')->group(function () {
    Route::resource('elements', 'AvailableElements')->only(['index', 'store']);
    Route::resource('game', 'Game')->only(['index', 'store']);
});
