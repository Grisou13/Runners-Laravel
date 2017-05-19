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
      Permission::create(["name"=>"view runs"]);

      Role::create([
          "name" => "runner"
      ])
      ->givePermissionTo('end run')
      ->givePermissionTo('view runs');

      Role::create([
        "name" => "administrator"
      ])
      ->givePermissionTo('end run')
      ->givePermissionTo('force run end')
      ->givePermissionTo('force run start');

      Role::create([
        "name" => "coordinator"
      ])
      ->givePermissionTo('end run')
      ->givePermissionTo('force run end')
      ->givePermissionTo('force run start');

      Role::create([
        "name" => "production_assistante"
      ]);
    }
}
