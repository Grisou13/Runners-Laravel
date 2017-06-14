<?php

use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CarTypeSeeder::class);
        $this->call(CarSeeder::class);
        $this->call(BaseSeeder::class);
        $this->call(UserProductionSeeder::class);
        $this->call(RunProductionSeeder::class);  // Commented out temporarily because of weird behaviour: start/end dates are not set by RunProductionSeeder if called from here, but are ok if called separately
    }
}
