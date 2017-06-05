<?php

use Lib\Models\Car;
use Lib\Models\CarType;
use Lib\Models\User;
use Illuminate\Database\Seeder;
use Lib\Models\Waypoint;
use Lib\Models\Run;

class RunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wp = Waypoint::create(["name"=>"Maison"]);

        $run = Run::create([ // run started
            'started_at' => '2017-07-12 08:00:00',
            'ended_at' => null,
            'planned_at' => '2017-07-12 00:00:00',
            'nb_passenger' => 8,
            'name' => 'RED HOT CHILI PEPPERS',
            'note' => "tcho",
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s'),
            'deleted_at' => null,
        ]);

        /*/

        if(!User::all()->count())
          $this->call(UserSeeder::class);
        collect(["Nyon centre","Lausanne Gare","Paleo grande scène","Genève aéroport", "Chavannes", "lake geneva hotel"])->each(function($n){
          Waypoint::create(["name"=>$n]);
        });
        $notes = collect([
          'Band départ 11 Pax',
          'Crew départ 1 Pax, 1 VALISE + 1 SAC',
          'invité arrivé 1 Pax',
          'crew départ 1 Pax, 1 grosse valise',
          'agent Départ 1 Pax',
          'band transfert 1 Pax',
          '1 cello / 1 KB flight case / 8 travel',
          'luggages',
          'divers transfert Pax'
        ]);

        $artists = [
          "KALEO",
          "THE INSPECTOR CLUZO",
          "SATE",
          "TAXIWARS",
          "BARBAGALLO",
          "ALICE ROOSEVELT",
          "FOREIGN DIPLOMATS",
          "THE STACHES"
        ];

        // seeds creation ========================

        $run = Run::create([ // run started
          'started_at' => '2017-07-12 08:00:00',
          'ended_at' => null,
          'planned_at' => '2017-07-12 00:00:00',
          'nb_passenger' => 8,
          'name' => 'RED HOT CHILI PEPPERS',
          'note' => $notes->first(),
          'created_at' => date('Y-m-d h:m:s'),
          'updated_at' => date('Y-m-d h:m:s'),
          'deleted_at' => null,
        ]);
        $run->waypoints()->attach(3);
        $run->waypoints()->attach(1);

        $run = Run::create([ // run ended and 0 passengers
          'started_at' => '2017-07-13 08:00:00',
          'ended_at' => '2017-07-13 12:00:00',
          'planned_at' => '2017-07-13 00:00:00',
          'nb_passenger' => 2,
          'name' => "FOALS",
          'note' => $notes[1],
          'created_at' => date('Y-m-d h:m:s'),
          'updated_at' => date('Y-m-d h:m:s'),
          'deleted_at' => null,
        ]);
        $run->waypoints()->attach(3);
        $run->waypoints()->attach(4);
        $run->waypoints()->attach(1);

        foreach($artists as $artist){
          $run = Run::create([
            'started_at' => null,
            'ended_at' => null,
            'planned_at' => '2017-07-13 20:49:18',
            'nb_passenger' => rand(1,5),
            'name' => $artist,
            'note' => $notes->random(),
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s'),
            'deleted_at' => null,
          ]);
          $run->waypoints()->attach(3);
          $run->waypoints()->attach(5);

          if(rand(0,100) % 2){
            $run->waypoints()->attach(1);
            $run->waypoints()->attach(2);
            $sub = new Lib\Models\RunSubscription();
            $sub->run()->associate($run);
            $sub->user()->associate(2);
            $sub->car_type()->associate(1);
            $sub->save();
          }
        }
        factory(Lib\Models\Waypoint::class,10)->create();
        factory(Lib\Models\Run::class,3)->create()->each(function(\Lib\Models\Run $run){
          $run->waypoints()->attach(Waypoint::all()->random(rand(2,4)));
        });

        $run = factory(Lib\Models\Run::class)->create();

        $run->waypoints()->attach(Waypoint::all()->random(rand(2,4)));
        $sub = new Lib\Models\RunSubscription();
        $sub->run()->associate($run);
        $sub->user()->associate(2);
        $sub->car()->associate(1);
        $sub->save();

        $run = factory(Lib\Models\Run::class)->create();
        $run->waypoints()->attach(Waypoint::all()->random(rand(2,4)));
        $sub = new Lib\Models\RunSubscription();
        $sub->run()->associate($run);
        $sub->user()->associate(3);
        $sub->car()->associate(3);
        $sub->save();

        $run = factory(Lib\Models\Run::class)->create();
        $run->waypoints()->attach(Waypoint::all()->random(rand(2,4)));
        $sub = new Lib\Models\RunSubscription();
        $sub->run()->associate($run);
        $sub->car()->associate(5);
        $sub->save();

        $run = factory(Lib\Models\Run::class)->create();
        $run->waypoints()->attach(Waypoint::all()->random(rand(2,4)));
        $sub = new Lib\Models\RunSubscription();
        $sub->run()->associate($run);
        $sub->user()->associate(6);
        $sub->save();

        $run = factory(Lib\Models\Run::class)->create();
        $run->waypoints()->attach(Waypoint::all()->random(rand(2,4)));
        $sub = new Lib\Models\RunSubscription();
        $sub->run()->associate($run);
        $sub->user()->associate(5);
        $sub->car_type()->associate(2);
        $sub->save();

        $run = factory(Lib\Models\Run::class)->create();
        $run->waypoints()->attach(Waypoint::all()->random(rand(2,4)));
        $sub = new Lib\Models\RunSubscription();
        $sub->run()->associate($run);
        $sub->car_type()->associate(2);
        $sub->save();

        $run = factory(Lib\Models\Run::class)->create();
        $run->waypoints()->attach(Waypoint::all()->random(rand(2,4)));
        $sub = new Lib\Models\RunSubscription();
        $sub->run()->associate($run);
        $sub->user()->associate(8);
        $sub->car_type()->associate(2);
        $sub->save();

        Run::create()
        //*/
    }
}
