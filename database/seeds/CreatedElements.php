<?php

use App\Models\Element;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use App\Models\CreatedElement;

class CreatedElements extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $elements = $this->groupById(Element::all());
        $count_recipes = $faker->numberBetween(1, count($elements) - 1);
        for ($i = 0; $i < $count_recipes; $i++) {
            $selected = $faker->randomElement($elements);
            $selected->createdElement()->save(factory(CreatedElement::class)->make());
            unset($elements[$selected->id]);
        }
    }

    protected function groupById(Collection $data)
    {
        $elements = [];
        foreach ($data->all() as $element) {
            $elements[$element->id] = $element;
        }
        return $elements;
    }
}
