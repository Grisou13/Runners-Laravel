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
        Car::unguard();
        // 12 Vito bus
        for ($i = 0; $i < 12; $i++)
        {
            Car::create([
                "plate_number" => "AI " . rand(1000000, 200000),
                "brand" => "Mercedes",
                "model" => "Vito",
                "color" => 'noir',
                "nb_place" => 9,
                "car_type_id" => 1
            ]);
        }
        // 2 Limos
        Car::create([
            "plate_number" => "VD " . rand(1000000, 200000),
            "brand" => "Mercedes",
            "model" => "S500",
            "color" => 'noir',
            "nb_place" => 4,
            "car_type_id" => 2
        ]);
        Car::create([
            "plate_number" => "VD " . rand(1000000, 200000),
            "brand" => "Mercedes",
            "model" => "S350",
            "color" => 'blue',
            "nb_place" => 4,
            "car_type_id" => 2
        ]);
        // 2 matos
        Car::create([
            "plate_number" => "VD " . rand(1000000, 200000),
            "brand" => "Peugeot",
            "model" => "Boxer",
            "color" => 'white',
            "nb_place" => 3,
            "car_type_id" => 3
        ]);
        Car::create([
            "plate_number" => "VD " . rand(1000000, 200000),
            "brand" => "Peugeot",
            "model" => "Kangoo",
            "color" => 'white',
            "nb_place" => 2,
            "car_type_id" => 3
        ]);

        Car::reguard();
    }
}
