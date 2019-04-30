<?php

use App\Models\{InitialElement, Recipe};
use Faker\Generator;
use Illuminate\Database\Seeder;
use App\Models\Element;
use Faker\Factory as Faker;

class Recipes extends Seeder
{
    /**
     * Warning: can create the same recipes!
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $initial_elements = array_column(InitialElement::all()->all(), null,'element_id');
        $elements = Element::whereNotIn('id', array_keys($initial_elements))->get()->all();

        // based on initial elements
        $elements_level = array_keys($initial_elements);
        while($elements) {
            $components = array_column(Element::whereIn('id', $elements_level)->get()->all(), null,'id');
            $recipe_variants = $this->makeUniqueRecipes(array_keys($components), 2);
            $elements_level = $this->makeNextLevel(
                $faker,
                $recipe_variants,
                $elements,
                $faker->numberBetween(1, count($recipe_variants))
            );
            array_splice($elements, 0, count($elements_level));
            if (count($elements) < 2 || count($elements_level) < 2) {
                return;
            }
        }
    }

    protected function makeNextLevel(Generator $faker, array $recipe_variants, array $elements, int $count_recipes)
    {
        $result = [];
        for ($i = 0; $i < $count_recipes; $i++) {
            $count = 2;
            $component_key = $faker->randomElement(array_keys($recipe_variants));
            while ($count) {
                factory(Recipe::class)->create([
                    'element_id' => $elements[$i]->id,
                    'component_id' => $recipe_variants[$component_key][$count - 1]
                ]);
                $count--;
            }
            unset($recipe_variants[$component_key]);
            $result[] = $elements[$i]->id;
        }
        return $result;
    }

    protected function makeUniqueRecipes(array $elements, $elements_count, $current_level = 1, $prefix = [])
    {
        $result = [];
        foreach ($elements as $key => $element) {
            if ($elements_count !== $current_level) {
                $new_elements = $elements;
                array_splice($new_elements, 0, $key + 1);
                $data = $this->makeUniqueRecipes(
                    $new_elements,
                    $elements_count,
                    $current_level + 1,
                    [$element]
                );
                foreach ($data as $datum) {
                    $result[] = array_merge($prefix, $datum);
                }
                continue;
            }
            $result[] = array_merge($prefix, [$element]);
        }

        if ($current_level !== 1) {
            return $result;
        }

        $data = [];
        foreach ($result as $record) {
            $data[implode('-', $record)] = $record;
        }

        return $data;
    }
}
