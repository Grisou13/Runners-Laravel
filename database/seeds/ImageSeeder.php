<?php

use Lib\Models\User;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Storage::disk("user_images")->put("example-profile-image.png",Storage::disk("storage")->get("fixtures/example-profile-image.png"));
      Storage::disk("user_images")->put("exemple-permis-conduire.png",Storage::disk("storage")->get("fixtures/exemple-permis-conduire.png"));
    }
}
