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

        factory(\App\Car::class,10)->create()->each(function(\App\Car $c){
            $c->type()->associate(factory(\App\CarType::class)->create());
        });
    }
}
