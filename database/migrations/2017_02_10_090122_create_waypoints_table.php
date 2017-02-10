<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaypointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("waypoints",function(Blueprint $table){
            $table->increments("id");
            $table->longText("geo");
        });
        Schema::create("waypoints_itineraries",function(Blueprint $table){
            $table->integer("waypoint_id")->unsigned();
            $table->foreign("waypoint_id")->references("id")->on("waypoints");
            $table->integer("itinerary_id")->unsigned();
            $table->foreign("itinerary_id")->references("id")->on("itineraries");
        });
        Schema::create('itineraries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("run_id")->unsigned();
            $table->foreign("run_id")->references("id")->on("runs");
            $table->string("name");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("waypoints_itineraries");
        Schema::dropIfExists('waypoints');
        Schema::create('itineraries');
    }
}
