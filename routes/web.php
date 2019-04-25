<?php

Route::get('/', 'Home');

Route::prefix('api/v1')->group(function () {
    Route::resource('elements', 'API\AvailableElements')->only(['index']);

    Route::post('elements/new-game', 'API\AvailableElements@newGame');
});
