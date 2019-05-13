<?php

use App\Models\Element;
use Illuminate\Database\Seeder;

class RealElements extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $elements = [
            'air', 'earth', 'fire', 'water',  // base elements

            'dust', 'swamp', 'lava', 'rock',
            'sand', 'metal', 'glass'
        ];
        foreach ($elements as $element_name) {
            Element::create(['name' => $element_name]);
        }
    }
}
