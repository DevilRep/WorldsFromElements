<?php

use App\Models\AvailableElement;
use App\Models\Element;
use App\Models\InitialElement;
use App\Models\Recipe;
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
        DB::statement('SET foreign_key_checks=1');
    }
}
