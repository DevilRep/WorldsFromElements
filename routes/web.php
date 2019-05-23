<?php

Route::get('/{any?}', 'Home')->where('any', '.*');
