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
            $table->longText("geo")->nullable()->comment("Google geocoder result.");
            $table->longText("latlng")->nullable()->comment("latitude and longitude of waypoint. Stored as json {lat:....,lng:...}");
            $table->string("name")->comment("nickname for the waypoint. Defined by the user");
          $table->timestamps();
        });
      Schema::create("run_waypoint",function(Blueprint $table){
        $table->unsignedInteger("waypoint_id");
        $table->foreign("waypoint_id")->references("id")->on("waypoints");
        $table->unsignedInteger("run_id");
        $table->foreign("run_id")->references("id")->on("runs");
        $table->integer("order")->comment("Used to define the order of a waypoint in a run");
      });
      Schema::table("run_waypoint",function(Blueprint $table){
        //laravel cannot create field only increments without primary
        // so just dorp the primary constraint, no need for it
        // $table->index("order");
        // $table->index("run_id");
        // $table->index("waypoint_id");
        // $table->dropPrimary("run_waypoint_order_primary");
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
