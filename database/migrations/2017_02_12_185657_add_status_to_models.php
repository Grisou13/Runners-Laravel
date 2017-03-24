<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("users",function(Blueprint $table){
            $table->string("status")->nullable();
        });
        Schema::table("run_drivers",function(Blueprint $table){
          $table->string("status")->nullable();
        });
        Schema::table("cars",function(Blueprint $table){
            $table->string("status")->nullable();
        });
        Schema::table("runs",function(Blueprint $table){
          $table->string("status")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      //just change stuuff for mysql, so that we can test
      if(strtolower(env("DB_CONNECTION")) != "sqlite"){
        Schema::table("users",function(Blueprint $table){
          $table->dropColumn("status");
        });
        Schema::table("cars",function(Blueprint $table){
          $table->dropColumn("status");
        });
        Schema::table("run_drivers",function(Blueprint $table){
          $table->dropColumn("status");
        });
        Schema::table("runs",function(Blueprint $table){
          $table->dropColumn("status");
        });
      }
    }
}
