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
        Schema::create("run_drivers", function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("car_id")->nullable();
            $table->unsignedInteger("user_id")->nullable();
            $table->unsignedInteger("run_id");
            $table->unsignedInteger("car_type_id")->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign("car_id")->references("id")->on("cars");
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("run_id")->references("id")->on("runs")->onDelete("cascade");
            $table->foreign("car_type_id")->references("id")->on("car_types");
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

    }
}
