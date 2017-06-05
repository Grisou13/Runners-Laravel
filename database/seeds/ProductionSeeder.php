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
      $this->call(RoleSeeder::class);
      $this->call(UserProductionSeeder::class);
      $this->call(RunProductionSeeder::class);
    }
}
