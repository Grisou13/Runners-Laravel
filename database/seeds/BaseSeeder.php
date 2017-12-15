<?php

use Illuminate\Database\Seeder;

/**
 * Class BaseSeeder
 * This seeder is called to instantiate all the basic models that need to be hydrated in the database.
 * If these models aren't migrated, the app will not work!!
 */
class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(SettingsSeeder::class);
    }
}
