<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCarTypesToCarType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("cars",function(Blueprint $table){
            $table->dropForeign(['car_types_id']);
            $table->dropColumn(['car_types_id']);
            $table->integer('car_type_id')->unsigned();
            $table->foreign('car_type_id')->references('id')->on('car_types')->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("cars",function(Blueprint $table){
            $table->dropForeign(['car_type_id']);
            $table->dropColumn(['car_type_id']);
            $table->integer('car_types_id')->unsigned();
            $table->foreign('car_types_id')->references('id')->on('car_types');
        });
    }
}
