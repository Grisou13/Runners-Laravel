<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Artisan::call("cache:forget",["key"=>"spatie.permission.cache"]);
      Permission::create(["name"=>"end run"]);
      Permission::create(["name"=>"start run"]);
      Permission::create(["name"=>"force run end"]);
      Permission::create(["name"=>"force run start"]);
      Permission::create(["name"=>"publish run"]);
      Permission::create(["name"=>"update run"]);
      Permission::create(["name"=>"view runs"]);
      Permission::create(["name"=>"edit run"]);
      Permission::create(["name"=>"edit settings"]);
      Permission::create(["name"=>"create settings"]);
      Permission::create(["name"=>"delete settings"]);

      Permission::create(["name"=>"edit all profile images"]);


      Role::create([
        "name"=>"anonymous"
      ])
      ->givePermissionTo('view runs')
      ;

      Role::create([
          "name" => "runner"
      ])
      ->givePermissionTo('end run')
      ->givePermissionTo('start run')
      ->givePermissionTo('view runs');

      Role::create([
        "name" => "admin"
      ])
      ->givePermissionTo('end run')
      ->givePermissionTo('force run end')
      ->givePermissionTo('edit run')
      ->givePermissionTo('publish run')
      ->givePermissionTo('update run')
      ->givePermissionTo('start run')
      ->givePermissionTo('force run start')
      ->givePermissionTo('edit settings')
      ->givePermissionTo('create settings')
      ->givePermissionTo('delete settings')
      ->givePermissionTo('edit all profile images')
      ;

      Role::create([
        "name" => "coordinator"
      ])
      ->givePermissionTo('end run')
      ->givePermissionTo('publish run')
      ->givePermissionTo('edit run')
      ->givePermissionTo('update run')
      ->givePermissionTo('force run end')
      ->givePermissionTo('start run')
      ->givePermissionTo('force run start')
      ->givePermissionTo('edit settings')
      ->givePermissionTo('create settings')
      ->givePermissionTo('delete settings')
      ->givePermissionTo('edit all profile images')
      ;

      Role::create([
        "name" => "production_assistante"
      ])
      ->givePermissionTo('view runs')
      ;
    }
}
