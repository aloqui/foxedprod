<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesPortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images_portfolios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('rubric_set_id')->nullable();
            $table->unsignedInteger('activity_id')->nullable();
            $table->unsignedInteger('score_id')->nullable();
            $table->boolean('submitted')->default(false);
            $table->boolean('evaluated')->nullable();
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
        Schema::dropIfExists('images_portfolios');
    }
}
