<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });
        if(strtolower(env("DB_CONNECTION")) == "sqlite") {
          Schema::table('cars', function (Blueprint $table) {
            $table->integer('car_type_id')->unsigned()->nullable()->default("");
            $table->foreign('car_type_id')->references('id')->on('car_types');
          });
        }
        else {
          Schema::table('cars', function (Blueprint $table) {
            $table->integer('car_type_id')->unsigned();
            $table->foreign('car_type_id')->references('id')->on('car_types');
          });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table("cars",function (Blueprint $table){
        $table->dropForeign(["car_type"]);
        $table->dropColumn("car_type_id");
      });
      Schema::dropIfExists('car_types');
    }
}
