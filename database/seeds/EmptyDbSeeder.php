<?php

use Illuminate\Database\Seeder;
use Lib\Models\User;

class EmptyDbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $db = \Config::get('database.connections.mysql.database');
        $user = \Config::get('database.connections.mysql.username');
        $pass = \Config::get('database.connections.mysql.password');
        exec("mysql -u " . $user . " -p" . $pass . " -h " . \Config::get("database.connections.mysql.host") . " " . $db . " < " . database_path("seeds/empty_db.sql"));
    }
}
