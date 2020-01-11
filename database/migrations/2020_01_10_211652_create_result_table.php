<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fixture_id');
            $table->unsignedTinyInteger('home_goal');
            $table->unsignedBigInteger('away_goal');
            $table->timestamps();
        });

        Schema::table('result', function (Blueprint $table) {
            $table->foreign('fixture_id')->references('id')->on('fixture');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('result');
    }
}
