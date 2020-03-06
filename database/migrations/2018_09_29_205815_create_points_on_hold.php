<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsOnHold extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points_on_hold', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('action_id')->nullable();
            $table->string('action_type')->nullable();
            $table->string('reason')->nullable();
            $table->tinyInteger('is_approved')->default(0);
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
        Schema::dropIfExists('points_on_hold');
    }
}
