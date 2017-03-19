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
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });
        Schema::table('cars', function (Blueprint $table) {
          $table->integer('car_type_id')->unsigned();
          $table->foreign('car_type_id')->references('id')->on('car_types');
        });
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
