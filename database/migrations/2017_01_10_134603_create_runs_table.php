<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('runs', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('started_date')->nullable();
            $table->dateTime('ended_date')->nullable();
            $table->dateTime("planned_at");
            $table->integer("nb_passenger");
            $table->string("artist")->nullable();
            $table->string('name');
            $table->string("note")->nullable();
            $table->timestamps();
           $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('runs');
    }
}
