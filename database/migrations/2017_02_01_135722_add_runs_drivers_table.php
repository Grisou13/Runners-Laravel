<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRunsDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("run_driver", function (Blueprint $table) {
            $table->unsignedInteger("car_id");
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("run_id");
            $table->foreign("car_id")->references("id")->on("cars");
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("run_id")->references("id")->on("runs");
        });

        Schema::table("runs", function(Blueprint $table){
            $table->dropForeign(["car_id"]);
            $table->dropForeign(["user_id"]);
            $table->dropColumn("car_id");
            $table->dropColumn("user_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("run_driver");

        Schema::table("runs", function(Blueprint $table){
            $table->unsignedInteger("car_id");
            $table->unsignedInteger("user_id");
            $table->foreign("car_id")->references("id")->on("cars");
            $table->foreign("user_id")->references("id")->on("cars");
        });
    }
}
