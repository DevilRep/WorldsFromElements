<?php

use App\Models\{User, AvailableElement, Element, InitialElement, Recipe};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClearAll extends Seeder
{
    /**
     * Run the database seeds.
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
        User::truncate();
        DB::statement('SET foreign_key_checks=1');
    }
}
