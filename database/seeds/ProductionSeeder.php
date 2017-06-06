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
        $this->call(EmptyDbSeeder::class);
        $this->call(CarTypeSeeder::class);
        $this->call(CarSeeder::class);
        $this->call(BaseSeeder::class);
        $this->call(UserProductionSeeder::class);
        $this->call(RunProductionSeeder::class);
    }
}
