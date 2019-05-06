<?php

use App\Models\InitialElement;
use App\Models\Element;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class InitialElements extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $elements = array_column(Element::all()->all(), null, 'id');
        $count_recipes = $faker->numberBetween(3, (count($elements) - 1) / 2);
        for ($i = 0; $i < $count_recipes; $i++) {
            $selected = $faker->randomElement($elements);
            $selected->availableElement()->save(factory(InitialElement::class)->make());
            unset($elements[$selected->id]);
        }
    }
}
