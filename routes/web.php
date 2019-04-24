<?php

Route::get('/', 'Home');

Route::prefix('api/v1')->group(function () {
    Route::resource('elements/available', 'API\AvailableElements')->only(['index']);
});
