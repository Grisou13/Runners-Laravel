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
      /*$colors = ['Bleu', 'Vert', 'Rouge'];
      $nb_places = [2, 5, 8];
      $status = ['Disponible', 'En réparation'];*/

      factory(Lib\Models\Car::class,10)->create();
    }
}
