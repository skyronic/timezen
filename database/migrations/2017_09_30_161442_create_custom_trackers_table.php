<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_trackers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('timezone')->default('UTC');
            $table->string('name');
            $table->integer('day_start')->default('16');
            $table->integer('ideal_start')->default('20');
            $table->integer('ideal_end')->default('34');
            $table->integer('day_end')->default('36');
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('custom_trackers');
    }
}
