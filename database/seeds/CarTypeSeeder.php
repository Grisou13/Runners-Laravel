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
          "description"=>"Description de la voiture VITO !"
      ]);
      Lib\Models\CarType::create([
          "name"=>"LIMO",
          "description"=>"Description de la voiture LIMO !"
      ]);
      Lib\Models\CarType::create([
          "name"=>"MATOS",
          "description"=>"Description de la voiture MATOS !"
      ]);
    }
}
