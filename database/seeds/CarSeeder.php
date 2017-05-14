<?php

use Illuminate\Database\Seeder;
use Lib\Models\Car;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
    /*  $ids = \Lib\Models\CarType::all()->pluck("id");
      factory(Lib\Models\Car::class,10)->create(["car_type_id"=>$ids->random()]);*/

      for($i = 0; $i < 10; $i++){

        Car::create([
          "plate_number"=>"VD ".rand(1000000,200000),
          "brand"=>collect(["BMW","Suzuki","Renault","Hyundai"])->random(),
          "model"=>collect(["Serie 4", "Monospace", "Truc"])->random(),
          "color" => 'noir',
          "nb_place" => rand(3, 6),
          "car_type_id" => rand(1,2)
        ]);
      }
      for($i = 0; $i < 10; $i++){
    
        Car::create([
          "plate_number"=>"VD ".rand(1000000,200000),
          "brand"=>collect(["Suzuki","Renault","Hyundai"])->random(),
          "model"=>collect(["Monospace", "Camion"])->random(),
          "color" => 'noir',
          "nb_place" => rand(5, 12),
          "car_type_id" => rand(3,5)
        ]);
      }
    }
}
