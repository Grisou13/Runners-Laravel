<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // create_users
      Schema::table('users', function (Blueprint $table) {
        $table->integer('role_id')->nullable()->unsigned();
        $table->foreign('role_id')->references('id')->on('roles');
        $table->integer('group_id')->nullable()->unsigned();
        $table->foreign('group_id')->references('id')->on('groups');
      });
      //runs
      Schema::table('runs', function (Blueprint $table) {
        $table->integer('user_id')->unsigned();
        $table->foreign('user_id')->references('id')->on('users');
      });

      //cars
      Schema::table('cars', function (Blueprint $table) {
        $table->integer('car_types_id')->unsigned();
        $table->foreign('car_types_id')->references('id')->on('car_types');

      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      // create_users
      Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['role_id']);
        $table->dropForeign(['group_id']);
        $table->dropColumn(['role_id', 'group_id']);
      });
      //runs
      Schema::table('runs', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn(['user_id']);
      });

      //cars
      Schema::table('cars', function (Blueprint $table) {
        $table->dropForeign(['car_types_id']);
        $table->dropColumn(['car_types_id']);
      });
    }
}
