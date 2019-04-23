<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Element;
use Faker\Generator as Faker;

$factory->define(Element::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
