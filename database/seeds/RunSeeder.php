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
        /*
        if(!User::all()->count())
            $this->call(UserSeeder::class);



        factory(\App\Run::class,10)->create()->each(function(\App\Run $run){
            $run->user()->associate(User::find(2));
        });
        */
    }
}
