<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreatedElement extends Model
{
    public function element()
    {
        return $this->hasOne('App\Models\Element');
    }
}
