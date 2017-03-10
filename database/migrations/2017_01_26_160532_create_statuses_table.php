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
            $table->string("type");
            $table->string("name");
            $table->string("displayname");
        });
        
        Schema::create("statusables",function(Blueprint $table){
            $table->morphs("statusable");
          $table->integer("status_id")->references("id")->on("statuses");
        });
      Schema::dropIfExists('statuses');
      Schema::dropIfExists('statusables');
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
