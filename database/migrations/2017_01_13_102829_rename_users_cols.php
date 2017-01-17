<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameUsersCols extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('first_name', 'firstname');
            $table->renameColumn("last_name","lastname");
            $table->renameColumn("phone","phone_number");
            $table->renameColumn("qr_code","accesstoken");
            $table->renameColumn("shortname","name");
            $table->string("name",40)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('firstname','first_name');
            $table->renameColumn("lastname","last_name");
            $table->renameColumn("phone_number","phone");
            $table->renameColumn("accesstoken","qr_code");
            $table->string("shortname")->unique()->change();
        });
    }
}
