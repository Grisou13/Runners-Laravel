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
            $table->longText("geo")->nullable();
            $table->longText("latlng")->nullable();
            $table->string("name");
          $table->timestamps();
        });
      Schema::create("run_waypoint",function(Blueprint $table){
        $table->unsignedInteger("waypoint_id");
        $table->foreign("waypoint_id")->references("id")->on("waypoints");
        $table->unsignedInteger("run_id");
        $table->foreign("run_id")->references("id")->on("runs");
        $table->integer("order")->comment("Used to define the order of a waypoint in a run");
      });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists("run_waypoint");
        Schema::dropIfExists('waypoints');
    }
}
