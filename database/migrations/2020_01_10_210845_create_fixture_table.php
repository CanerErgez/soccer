<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixtureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixture', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('home_team');
            $table->unsignedBigInteger('away_team');
            $table->unsignedInteger('week');
            $table->unsignedInteger('year');
            $table->timestamps();
        });

        Schema::table('fixture', function (Blueprint $table) {
            $table->foreign('home_team')->references('id')->on('team');
            $table->foreign('away_team')->references('id')->on('team');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fixture');
    }
}
