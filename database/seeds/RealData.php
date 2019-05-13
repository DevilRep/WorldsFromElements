<?php

use Illuminate\Database\Seeder;

class RealData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClearAll::class);
        $this->call(RealElements::class);
        $this->call(RealInitialElements::class);
        $this->call(RealRecipes::class);
        $this->call(RealAvailableElements::class);
    }
}
