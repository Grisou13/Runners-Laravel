<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("schedule_groups", function(Blueprint $table){
            $table->increments("id");
            $table->unsignedInteger("group_id");
            $table->foreign("group_id")->references("id")->on("groups")->onDelete("cascade");
            $table->dateTime("start_time");
            $table->dateTime("end_time");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("schedule_groups");
    }
}
