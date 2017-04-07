<?php

use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
      $ids = \Lib\Models\CarType::all()->pluck("id");
      factory(Lib\Models\Car::class,10)->create(["car_type_id"=>$ids->random()]);
    }
}
