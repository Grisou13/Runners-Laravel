<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sta = \App\Helpers\Status::getUserStatus("actif");

        Lib\Models\User::create([
            "email"=>"root@localhost",
            "phone_number"=>"",
            "sex"=>true,
            "accesstoken"=>"root",
            "firstname"=>"root",
            "name"=>"rootsey",
            "lastname"=>"toor",
            "password"=>bcrypt("root"),
            "status"=>$sta
        ]);
        factory(Lib\Models\User::class,3)->create();
        factory(Lib\Models\User::class,5)->create()->each(function(Lib\Models\User $u){
            $u->group()->associate(factory(Lib\Models\User::class)->make());
        });
//        factory(\App\Schedule::class, 5)->create()->each(function($schedule){
//            $schedule->group()->associate(Group::find(rand(0,5)));
//        });
    }
}
