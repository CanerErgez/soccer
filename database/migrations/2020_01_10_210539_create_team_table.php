<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('league_id');
            $table->string('name');
            $table->unsignedInteger('strength');
            $table->timestamps();
        });

        Schema::table('team', function (Blueprint $table) {
            $table->foreign('league_id')->references('id')->on('league');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team');
    }
}
