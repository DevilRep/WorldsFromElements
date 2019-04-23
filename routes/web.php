<?php

Route::get('/', 'Home');

Route::prefix('api/v1')->group(function () {
    Route::resource('elements', 'API\Element')->only(['index']);
});
