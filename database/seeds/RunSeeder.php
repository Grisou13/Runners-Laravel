<?php

use Lib\Models\User;
use Illuminate\Database\Seeder;

class RunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if(!User::all()->count())
            $this->call(UserSeeder::class);
        factory(Lib\Models\Run::class,10)->create()->each(function(\Lib\Models\Run $run){
          $run->waypoints()->attach(factory(Lib\Models\Waypoint::class)->create());
          $run->waypoints()->attach(factory(Lib\Models\Waypoint::class)->create());
          if(rand(0,200) % 2){ //just add some more data
            for($i=0;$i<=5;$i++)
              $run->waypoints()->attach(factory(Lib\Models\Waypoint::class)->create());
          }
        });


    }
}
