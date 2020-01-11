<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePredictionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prediction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('team_id');
            $table->unsignedInteger('week');
            $table->unsignedInteger('year');
            $table->float('odds')->nullable();
            $table->timestamps();
        });

        Schema::table('prediction', function (Blueprint $table) {
            $table->foreign('team_id')->references('id')->on('team');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prediction');
    }
}
