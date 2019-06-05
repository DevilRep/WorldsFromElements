<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableElement extends Model
{
    protected $fillable = ['element_id', 'user_id'];

    public function element()
    {
        return $this->belongsTo('App\Models\Element');
    }
}
