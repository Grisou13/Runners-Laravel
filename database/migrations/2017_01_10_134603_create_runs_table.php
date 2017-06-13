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
            $table->boolean('drafting')->default(true)->comment("Hard coded value of status=drafting, allowing the Object model to be easier to understand and manipulate");
            $table->dateTime('started_at')->nullable()->comment("Defines the date at which a run started");
            $table->dateTime('published_at')->nullable()->comment("Used for stats only, to get time between publishing");
            $table->dateTime('ended_at')->nullable();
            $table->dateTime("planned_at")->nullable();
            $table->integer("nb_passenger")->default(0);
            //$table->string("artist")->nullable();
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
