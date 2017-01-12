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


        $user = User::find(2);
        factory(\App\Run::class,10)->create()->each(function(\App\Run $run) use ($user){
            $run->user()->save($user);
        });

    }
}
