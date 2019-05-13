<?php

use App\Models\{ AvailableElement, InitialElement };
use Illuminate\Database\Seeder;

class RealAvailableElements extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $initial_elements = array_column(InitialElement::all()->all(), null, 'element_id');
        foreach ($initial_elements as $element) {
            /**
             * @var InitialElement $element
             */
            factory(AvailableElement::class)->create(['element_id' => $element->element_id]);
        }
    }
}
