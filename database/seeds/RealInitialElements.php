<?php

use App\Models\{ InitialElement, Element };
use Illuminate\Database\Seeder;

class RealInitialElements extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Element::whereIn('name', ['earth', 'fire', 'air', 'water'])->get()->each(function ($element) {
            /**
             * @var Element $element
             */
            $element->availableElement()->save(factory(InitialElement::class)->make());
        });
    }
}
