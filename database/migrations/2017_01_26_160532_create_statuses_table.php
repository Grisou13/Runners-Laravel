<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id');
            //$table->morphs("statable");
            $table->string("type")->nullable();
            $table->string("key")->unique();
            $table->string("value",2048);
            $table->string("display_name")->nullable();
            $table->integer("weight")->default(1);
        });

        Schema::dropIfExists('statuses');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}
