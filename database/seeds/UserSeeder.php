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

        \App\User::create([
            "email"=>"root@localhost",
            "phone_number"=>"",
            "sex"=>true,
            "accesstoken"=>"root",
            "firstname"=>"root",
            "name"=>"rootsey",
            "lastname"=>"toor",
            "password"=>bcrypt("root")
        ]);
        factory(\App\User::class,10)->create();
//        factory(\App\User::class,5)->create()->each(function(\App\User $u){
//            $u->group()->save(factory(\App\Group::class)->make());
//        });
    }
}
