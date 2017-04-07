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
        factory(Lib\Models\User::class,10)->create()->each(function($user){
          $img = factory(Lib\Models\Image::class)->states("profile")->make(["user_id"=>$user->id]);
          $img->save();
          $img = factory(Lib\Models\Image::class)->states("license")->make(["user_id"=>$user->id]);
          $img->save();
        });

    }
}
