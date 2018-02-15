<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('channel_id');
            $table->string('name', 30);
            $table->string('slug', 30);
            $table->string('description', 80);
            $table->unsignedInteger('threads_count')->default(0);
            $table->timestamps();

            $table->foreign('channel_id')
            ->references('id')
            ->on('channels')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channels');
    }
}
