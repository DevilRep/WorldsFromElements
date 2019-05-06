<?php

use Illuminate\Database\Seeder;
use App\Models\{AvailableElement, Element, InitialElement, Recipe};
use \Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET foreign_key_checks=0');
        AvailableElement::truncate();
        InitialElement::truncate();
        Recipe::truncate();
        Element::truncate();
        DB::statement('SET foreign_key_checks=1');

        $this->call(Elements::class);
        $this->call(InitialElements::class);
        $this->call(Recipes::class);
        $this->call(AvailableElements::class);
    }
}
