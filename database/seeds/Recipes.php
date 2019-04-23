<?php

use Illuminate\Database\Seeder;
use App\Models\Element;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Collection;

class Recipes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $elements = Element::all()->all();
        $count_recipes = $faker->numberBetween(1, count($elements) - 1);
        for ($i = 0; $i < $count_recipes; $i++) {
            $count = $faker->numberBetween(1, count($elements) - 1);
            $components = array_column(
                Element::whereNotIn('id', [$elements[$i]->id])->get()->all(),
                null,
                'id'
            );
            while ($count) {
                $component = $faker->randomElement($components);
                /**
                 * @var Element $elements[$i]
                 */
                $elements[$i]->components()->save($component);
                unset($components[$component->id]);
                $count--;
            }
        }
    }
}
