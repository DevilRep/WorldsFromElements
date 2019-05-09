<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    public $timestamps = false;

    public function element()
    {
        return $this->belongsTo('App\Models\Element');
    }

    public function component()
    {
        return $this->belongsTo('App\Models\Element', 'component_id');
    }
}
