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

      //create a system user, used for comments, and "automatic data insertion in models"
      //TODO secure these models and passwords
      /* $system = Lib\Models\User::create([
        "email"=>"system@localhost",
        "phone_number"=>"",
        "sex"=>true,
        "accesstoken"=>"system",
        "firstname"=>"system",
        "name"=>"system",
        "lastname"=>"system",
        "password"=>bcrypt("system")
      ]);
      $system->assignRole("admin"); */
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
      $port   = \Config::get('database.connections.mysql.port');
      $host   = \Config::get("database.connections.mysql.host");
      // running command line import in php code
      exec("mysql -u $user -p$pass -h $host -P $port $db < ".database_path("seeds/runners_seed.sql"));

//      \DB::connection()->getPdo()->exec(file_get_contents(database_path("seeds/runners_seed.sql")));
//      $count = User::count();
//      $skip = 2;
//      $limit = $count - $skip; // the limit
      $users = User::where("id",">",3)->get();
      dump($users->count());
      $users->each(function(User $user){
        \File::copy(storage_path("fixtures/profile_images/".($user->id-2).".png"),storage_path("tmp/".($user->id-2).".png"));
        $user->addProfileImage(new Illuminate\Http\File(storage_path("tmp/".($user->id-2).".png")),true);
        $user->password = bcrypt($user->password);
        $user->name = $user->firstname;
        $user->email=filter_var(strtolower($user->firstname).".".strtolower($user->lastname)."@paleo.ch",FILTER_SANITIZE_EMAIL);
        $user->assignRole("runner");

        $user->save();
      });
      $coordUsers = User::whereHas("group", function($query){return $query->where("name","like","c%");})->get();
      $coordUsers->each(function($user){
        $user->assignRole("coordinator");
      });

    }
}
