<?php

use Illuminate\Database\Seeder;
use Lib\Models\Setting;
class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $settings = config("settings");
//      foreach($settings as $setting){
//        foreach($setting as $key=>$value)
//          Setting::create(["key"=>"{$setting}::{$key}","value"=>$value]);
//      }
      Setting::create(["key" => "start_date", "value" => "2017-07-13"]);
      Setting::create(["key" => "end_date", "value" => "2017-07-27"]);
    }
}
