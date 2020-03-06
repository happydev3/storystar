<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('nominated_by');
            $table->integer('story_id');
            $table->integer('points')->default(0);
            $table->text('comments')->nullable();
            $table->tinyInteger('is_approved')->default(0);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contest_entries');
    }
}
