<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InitialElement extends Model
{
    public function element()
    {
        return $this->belongsTo('App\Models\Element');
    }
}
