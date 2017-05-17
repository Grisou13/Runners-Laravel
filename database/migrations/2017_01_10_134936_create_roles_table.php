<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      return true;
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('display_name')->nullable();
        });
      Schema::create('permissions', function (Blueprint $table) {
        $table->increments('id');
        $table->timestamps();
        $table->string('name');
        $table->string('display_name')->nullable();
      });
      Schema::create('permissions_roles', function (Blueprint $table) {

        $table->unsignedInteger('role_id');
        $table->unsignedInteger('permission_id');
        $table->foreign('role_id')->references("id")->on("roles");
        $table->foreign('permission_id')->references("id")->on("permissions");
      });
      Schema::create('roles', function (Blueprint $table) {
        $table->increments('id');
        $table->timestamps();
        $table->string('role');
      });
        Schema::table('users', function (Blueprint $table) {
          $table->integer('role_id')->nullable()->unsigned();
          $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      return true;
        Schema::dropIfExists('roles');
    }
}
