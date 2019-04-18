<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InitialElement extends Model
{
    public function element()
    {
        return $this->hasOne('App\Models\Element');
    }
}
