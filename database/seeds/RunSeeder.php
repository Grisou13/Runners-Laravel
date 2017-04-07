<?php

use Lib\Models\Car;
use Lib\Models\CarType;
use Lib\Models\User;
use Illuminate\Database\Seeder;
use Lib\Models\Waypoint;

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
    
      factory(Lib\Models\Waypoint::class,10)->create();
    //just create 3 empty waypoints
      factory(Lib\Models\Run::class,3)->create()->each(function(\Lib\Models\Run $run){
        $run->waypoints()->attach(Waypoint::all()->random(rand(2,6)));
      });
    
      $run = factory(Lib\Models\Run::class)->create();
        
      $run->waypoints()->attach(Waypoint::all()->random(rand(2,6)));
      $sub = new Lib\Models\RunSubscription();
      $sub->run()->associate($run);
      $sub->user()->associate(2);
      $sub->car()->associate(1);
      $sub->save();
      
      $run = factory(Lib\Models\Run::class)->create();
      $run->waypoints()->attach(Waypoint::all()->random(rand(2,6)));
      $sub = new Lib\Models\RunSubscription();
      $sub->run()->associate($run);
      $sub->user()->associate(3);
      $sub->car()->associate(3);
      $sub->save();
      
      $run = factory(Lib\Models\Run::class)->create();
      $run->waypoints()->attach(Waypoint::all()->random(rand(2,6)));
      $sub = new Lib\Models\RunSubscription();
      $sub->run()->associate($run);
      $sub->car()->associate(5);
      $sub->save();
      
      $run = factory(Lib\Models\Run::class)->create();
      $run->waypoints()->attach(Waypoint::all()->random(rand(2,6)));
      $sub = new Lib\Models\RunSubscription();
      $sub->run()->associate($run);
      $sub->user()->associate(6);
      $sub->save();
      
      $run = factory(Lib\Models\Run::class)->create();
      $run->waypoints()->attach(Waypoint::all()->random(rand(2,6)));
      $sub = new Lib\Models\RunSubscription();
      $sub->run()->associate($run);
      $sub->user()->associate(5);
      $sub->car_type()->associate(2);
      $sub->save();
      
      $run = factory(Lib\Models\Run::class)->create();
      $run->waypoints()->attach(Waypoint::all()->random(rand(2,6)));
      $sub = new Lib\Models\RunSubscription();
      $sub->run()->associate($run);
      $sub->car_type()->associate(2);
      $sub->save();
      
      $run = factory(Lib\Models\Run::class)->create();
      $run->waypoints()->attach(Waypoint::all()->random(rand(2,6)));
      $sub = new Lib\Models\RunSubscription();
      $sub->run()->associate($run);
      $sub->user()->associate(8);
      $sub->car_type()->associate(2);
      $sub->save();
    }
}
