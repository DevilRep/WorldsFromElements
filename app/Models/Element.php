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

    public function components()
    {
        return $this->belongsToMany(
            'App\Models\Element',
            'recipes',
            'element_id',
            'component_id'
        );
    }

    public function createdElement()
    {
        return $this->hasOne('App\Models\AvailableElement');
    }

    public function initialElement()
    {
        return $this->hasOne('App\Models\InitialElement');
    }
}
