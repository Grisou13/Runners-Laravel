<?php

use App\Http\Helpers\Helper;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $alphabet = Helper::mkrange("A", "ZZ");
        $i = 0;

        factory(Lib\Models\Group::class, 5)->create()->each(function($g) use($alphabet, &$i){
            $g->name = $alphabet[$i];
            $i += 1;
            $g->save();
        });
    }
}
