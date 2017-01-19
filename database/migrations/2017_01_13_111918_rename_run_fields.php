<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameRunFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('runs', function (Blueprint $table) {
            $table->text("geo_from");
            $table->text("geo_to");

            $table->renameColumn('start_date', 'start_at');
            $table->renameColumn("end_date","end_at");

            $table->dropColumn(["start_site","arrival_site"]);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('runs', function (Blueprint $table) {
            $table->dropColumn(["geo_from","geo_to"]);
            $table->string('start_site');
            $table->string('arrival_site');

        });
    }
}
