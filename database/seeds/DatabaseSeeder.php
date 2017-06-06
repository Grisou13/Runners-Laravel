<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // the order is important
        $this->call(GroupSeeder::class);
        $this->call(BaseSeeder::class);
        $this->call(UserSeeder::class); // OK
        $this->call(ImageSeeder::class);
        $this->call(CarTypeSeeder::class);
        $this->call(CarSeeder::class);
        $this->call(RunSeeder::class);
    }
}
