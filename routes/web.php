<?php

Route::any('/{any?}', 'Home')->where('any', '.*');
