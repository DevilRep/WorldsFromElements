<?php

use Illuminate\Database\Seeder;
use App\Models\{ Element, Recipe };

class RealRecipes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $elements = array_column(Element::all()->all(), null, 'name');

        $list = [
            'dust' => ['air', 'earth'],
            'swamp' => ['water', 'earth'],
            'lava' => ['earth', 'fire'],
            'rock' => ['water', 'lava'],
            'sand' => ['air', 'rock'],
            'metal' => ['fire', 'rock'],
            'glass' => ['fire', 'sand']
        ];

        foreach ($list as $element_name => $components) {
            foreach ($components as $component_name) {
                Recipe::create([
                    'element_id' => $elements[$element_name]->id,
                    'component_id' => $elements[$component_name]->id
                ]);
            }
        }
    }
}
