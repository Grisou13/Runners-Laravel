<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string("color");
            $table->string("name")->nullable();
            $table->boolean('active')->nullable()->comment("DEPRECEATED");
            $table->timestamps();
            
        });
        Schema::table("users",function(Blueprint $table){
          $table->integer('group_id')->unsigned()->nullable();
          $table->foreign('group_id')->references('id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table("users",function(Blueprint $table){
        $table->dropForeign(["group_id"]);
        $table->dropColumn("group_id");
      });
        Schema::dropIfExists('groups');
        
    }
}
