<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    public function recipes()
    {
        return $this->belongsToMany(
            'App\Models\Element',
            'recipes',
            'component_id',
            'element_id'
        );
    }
}
