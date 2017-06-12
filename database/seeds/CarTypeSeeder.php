<?php

use Illuminate\Database\Seeder;

class CarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
      Lib\Models\CarType::create([
          "name"=>"VITO",
          "description"=>"Bus 9 places pour les runs standard",
          "nb_place"=>5
      ]);
      Lib\Models\CarType::create([
          "name"=>"LIMO",
          "description"=>"Limousine pour VIP",
          "nb_place"=>10
      ]);
      Lib\Models\CarType::create([
          "name"=>"MATOS",
          "description"=>"Matériel",
          "nb_place"=>2
      ]);
    }
}
