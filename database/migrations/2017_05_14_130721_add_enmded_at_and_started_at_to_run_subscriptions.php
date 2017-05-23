<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnmdedAtAndStartedAtToRunSubscriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("run_drivers", function(Blueprint $table){
          $table->datetime("started_at")->nullable();
          $table->datetime("ended_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//      Schema::table("run_drivers", function(Blueprint $table){
//        $table->dropColumn("started_at");
//        $table->dropColumn("ended_at");
//      });
    }
}
