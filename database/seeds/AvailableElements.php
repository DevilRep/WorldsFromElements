<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\{Element, InitialElement, AvailableElement, User};

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
        $users = User::all()->all();
        $elements = array_column(
            Element::whereNotIn('id', array_keys($initial_elements))->get()->all(),
            null,
            'id'
        );
        foreach ($users as $user) {
            foreach ($initial_elements as $element) {
                /**
                 * @var InitialElement $element
                 */
                factory(AvailableElement::class)->create([
                    'element_id' => $element->element_id,
                    'user_id' => $user->id
                ]);
            }
            $count_recipes = $faker->numberBetween(1, 2);
            for ($i = 0; $i < $count_recipes; $i++) {
                $selected = $faker->randomElement($elements);
                factory(AvailableElement::class)->create([
                    'element_id' => $selected->id,
                    'user_id' => $user->id
                ]);
                unset($elements[$selected->id]);
            }
        }
    }
}
