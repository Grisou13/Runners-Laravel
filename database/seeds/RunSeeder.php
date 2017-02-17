<?php

use App\User;
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
        factory(\App\Run::class,10)->create();
        factory(\App\Waypoint::class,5)->create();
        
    }
}
