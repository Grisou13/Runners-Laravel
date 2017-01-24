<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCarFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("cars",function(Blueprint $table){
            $table->renameColumn("license_plates","plate_number");
            $table->renameColumn("seats","nb_place");
            $table->renameColumn("shortname","name");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("cars",function(Blueprint $table){
            $table->renameColumn("plate_number","license_plate");
            $table->renameColumn("nb_place","seats");
            $table->renameColumn("name","shortname");
        });
    }
}
