<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRawScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raw_scores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('score_id')->nullable();
            $table->unsignedInteger('criteria_num')->nullable();
            $table->unsignedInteger('raw')->nullable();
            $table->unsignedInteger('computed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raw_scores');
    }
}
