<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('images', function (Blueprint $table) {
        $table->increments('id');
        $table->timestamps();
        $table->string('filename')->comment("filepath on which the image needs to recovered. e.g images/profile/myImage.png");
        $table->string('type')->comment("Defines which type of image is used. as of now, license or profile"); // type is a varchar because it allows to filter more easily in the api
        $table->integer('user_id')->unsigned();
        $table->foreign("user_id")->references("id")->on("users");
//        $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('images');
    }
}
