<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Elements::class);
        $this->call(Recipes::class);
        $this->call(InitialElements::class);
        $this->call(CreatedElements::class);
    }
}
