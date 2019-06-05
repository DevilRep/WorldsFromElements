<?php

use Illuminate\Database\Seeder;
use App\Models\{AvailableElement, Element, InitialElement, Recipe};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClearAll::class);
        $this->call(Users::class);
        $this->call(Elements::class);
        $this->call(InitialElements::class);
        $this->call(Recipes::class);
        $this->call(AvailableElements::class);
    }
}
