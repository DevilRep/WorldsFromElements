<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreatedElement extends Model
{
    public function element()
    {
        return $this->belongsTo('App\Models\Element');
    }
}