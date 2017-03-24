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
            $sub = new Lib\Models\RunSubscription();
            $sub->run()->associate($run);

            //jongle entre les differente assoc
            $rand = rand(0, 2);
            if($rand == 0){
              $sub->car_type()->associate(rand(1,2));
            }elseif($rand == 1){
              $sub->user()->associate(DB::table('users')->inRandomOrder()->first()->id);
            }else{
              $sub->car()->associate(1);
              $sub->user()->associate(DB::table('users')->inRandomOrder()->first()->id);
            }

            $sub->save();
            for($i=0;$i<=3;$i++)
              $run->waypoints()->attach(factory(Lib\Models\Waypoint::class)->create());
          }
        });


    }
}
