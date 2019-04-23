<?php

use Illuminate\Database\Seeder;
use App\Models\Element;

class Elements extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Element::class, 10)->create();
    }
}
