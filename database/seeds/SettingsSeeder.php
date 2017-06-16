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
      foreach($settings as $setting => $sets){
        if(is_array($sets)) {
          foreach ($sets as $key => $value) {
            Setting::create(["key" => "{$setting}::{$key}", "value" => $value]);

          }
        }
        else{
          Setting::create(["key" => "{$setting}", "value" => $sets]);
        }
      }
      Setting::create(["key" => "start_date", "value" => "2017-07-13"]);
      Setting::create(["key" => "end_date", "value" => "2017-07-27"]);
    }
}
