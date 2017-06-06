<?php

use Illuminate\Database\Seeder;
use Lib\Models\User;

class UserProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      User::unguard();
      $root = Lib\Models\User::create([
        "email"=>"root@localhost",
        "phone_number"=>"",
        "sex"=>true,
        "accesstoken"=>"root",
        "firstname"=>"root",
        "name"=>"rootsey",
        "lastname"=>"toor",
        "password"=>bcrypt("root")
      ]);
      $root->assignRole("admin");
      // création d'un utilisateur driver
  
      $user = Lib\Models\User::create([
        "email" => "runner@localhost",
        "phone_number" => "",
        "sex"=>true,
        "accesstoken" => "runner",
        "firstname" => "runner",
        "lastname" => "rennur",
        "password"=>bcrypt("runner")
      ]);
      User::reguard();
      //$user->assignRole("runner");

      $db     = \Config::get('database.connections.mysql.database');
      $user   = \Config::get('database.connections.mysql.username');
      $pass   = \Config::get('database.connections.mysql.password');

      // running command line import in php code
      exec("mysql -u " . $user . " -p" . $pass . " -h ".\Config::get("database.connections.mysql.host")." " . $db . " < ".database_path("seeds/runners_seed.sql"));
      $count = User::count();
      $skip = 2;
      $limit = $count - $skip; // the limit
      $users = User::where("id",">",2)->get();
      $users->each(function(User $user){
        \File::copy(storage_path("fixtures/profile_images/".($user->id-1).".png"),storage_path("tmp/".($user->id-1).".png"));
        $user->addProfileImage(new Illuminate\Http\File(storage_path("tmp/".($user->id-1).".png")),true);
        $user->password = bcrypt($user->password);
        $user->name = $user->firstname;
        $user->save();
      });
    }
}
