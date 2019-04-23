<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\{Element, InitialElement, AvailableElement};

class AvailableElements extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $initial_elements = array_column(InitialElement::all()->all(), null, 'element_id');
        foreach ($initial_elements as $element) {
            /**
             * @var InitialElement $element
             */
            $element->element()->first()->createdElement()->save(factory(AvailableElement::class)->make());
        }
        $elements = array_column(
            Element::whereNotIn('id', array_keys($initial_elements))->get()->all(),
            null,
            'id'
        );
        $count_recipes = $faker->numberBetween(1, count($elements) - 1);
        for ($i = 0; $i < $count_recipes; $i++) {
            $selected = $faker->randomElement($elements);
            $selected->createdElement()->save(factory(AvailableElement::class)->make());
            unset($elements[$selected->id]);
        }
    }
}
