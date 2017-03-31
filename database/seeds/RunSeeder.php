<?php

use Lib\Models\Car;
use Lib\Models\CarType;
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
      
        $waypoints = factory(Lib\Models\Waypoint::class,6)->create();
        function createSub($run){
          $sub = new Lib\Models\RunSubscription();
          $sub->run()->associate($run);
          $sub->user()->associate(User::all()->random());
          $sub->car()->associate(Car::all()->random());
          $sub->save();
        }
        factory(Lib\Models\Run::class,3)->create()->each(function(\Lib\Models\Run $run) use ($waypoints){
          $run->waypoints()->attach($waypoints->random(rand(2,6)));
        });
      
        factory(Lib\Models\Run::class)->create()->each(function(\Lib\Models\Run $run) use ($waypoints){
          $run->waypoints()->attach($waypoints->random(rand(2,6)));
          $sub = new Lib\Models\RunSubscription();
          $sub->run()->associate($run);
          $sub->user()->associate(User::find(2));
          $sub->car()->associate(Car::find(1));
          $sub->save();
        });
      factory(Lib\Models\Run::class)->create()->each(function(\Lib\Models\Run $run) use ($waypoints){
        $run->waypoints()->attach($waypoints->random(rand(2,6)));
        $sub = new Lib\Models\RunSubscription();
        $sub->run()->associate($run);
        $sub->user()->associate(User::find(3));
        $sub->car()->associate(Car::find(3));
        $sub->save();
      });
      factory(Lib\Models\Run::class)->create()->each(function(\Lib\Models\Run $run) use ($waypoints){
        $run->waypoints()->attach($waypoints->random(rand(2,6)));
        $sub = new Lib\Models\RunSubscription();
        $sub->run()->associate($run);
        
        $sub->car()->associate(Car::find(5));
        $sub->save();
      });
      factory(Lib\Models\Run::class)->create()->each(function(\Lib\Models\Run $run) use ($waypoints){
        $run->waypoints()->attach($waypoints->random(rand(2,6)));
        $sub = new Lib\Models\RunSubscription();
        $sub->run()->associate($run);
        $sub->user()->associate(User::find(6));
        $sub->save();
      });
      factory(Lib\Models\Run::class)->create()->each(function(\Lib\Models\Run $run) use ($waypoints){
        $run->waypoints()->attach($waypoints->random(rand(2,6)));
        $sub = new Lib\Models\RunSubscription();
        $sub->run()->associate($run);
        $sub->user()->associate(User::find(5));
        $sub->car_type()->associate(CarType::find(2));
        $sub->save();
      });
      factory(Lib\Models\Run::class)->create()->each(function(\Lib\Models\Run $run) use ($waypoints){
        $run->waypoints()->attach($waypoints->random(rand(2,6)));
        $sub = new Lib\Models\RunSubscription();
        $sub->run()->associate($run);
        $sub->car_type()->associate(CarType::find(2));
        $sub->save();
      });
      factory(Lib\Models\Run::class)->create()->each(function(\Lib\Models\Run $run) use ($waypoints){
        $run->waypoints()->attach($waypoints->random(rand(2,6)));
        $sub = new Lib\Models\RunSubscription();
        $sub->run()->associate($run);
        $sub->user()->associate(User::find(8));
        $sub->car_type()->associate(CarType::find(2));
        $sub->save();
      });
      
      


    }
}
