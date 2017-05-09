<?php

use Illuminate\Database\Seeder;
use Lib\Models\User;
use Lib\Models\Role;

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
        $id_role = Lib\Models\Role::where("role", "runner")->first()->id;

        Lib\Models\User::create([
            "email"=>"root@localhost",
            "phone_number"=>"",
            "sex"=>true,
            "accesstoken"=>"root",
            "firstname"=>"root",
            "name"=>"rootsey",
            "lastname"=>"toor",
            "password"=>bcrypt("root"),
            "status"=>$sta,
            "role_id"=>Lib\Models\Role::where("role", "admin")->first()->id
        ]);

        // création d'un utilisateur driver
        Lib\Models\User::create([
          "email" => "runner@localhost",
          "phone_number" => "",
          "sex"=>true,
          "accesstoken" => "runner",
          "firstname" => "runner",
          "name" => "runnsey",
          "lastname" => "rennur",
          "password"=>bcrypt("runner"),
          "role_id" => $id_role,
          "status"=>$sta

        ]);
        /*factory(Lib\Models\User::class,10)->create()->each(function($user){
          $img = factory(Lib\Models\Image::class)->states("profile")->make(["user_id"=>$user->id]);
          $img->save();
          $img = factory(Lib\Models\Image::class)->states("license")->make(["user_id"=>$user->id]);
          $img->save();
        });*/
        // creating 10 users
        $users = collect([
          ["Xavier", "Carrel", 1],
          ["Anouchka", "Salzmann", 0],
          ["Carole", "Bourgeois", 0],
          ["Daniel", "Grosjean", 1],
          ["David", "Korkia", 1],
          ["Enrico", "Chiabudini", 1],
          ["Julien", "Borel", 1]
        ]);

        $users->each(function($user) use($id_role){
          User::create([
            "firstname" => $user[0],
            "lastname" => $user[1],
            "name"=> $user[0],
            "email" => strtolower(substr($user[0], 0, 3)) . "-" . strtolower(substr($user[1], 0, 3)) . "@gmail.com",
            "password" => bcrypt('secret'),
            "phone_number" => "07" . rand(7,9) . " " . rand(100,999) . " " . rand(10, 99) . " " . rand(10, 99),
            "sex" => $user[2],
            "role_id" => $id_role,
            "remember_token" => str_random(10),
            "accesstoken"=>str_random(255)
          ]);
        });
    }
}
