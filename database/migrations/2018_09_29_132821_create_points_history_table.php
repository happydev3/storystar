
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('points_category_id');
            $table->integer('user_id');
            $table->integer('given_user_id')->nullable();
            $table->integer('action_id')->nullable();
            $table->string('action_type')->nullable();
            $table->integer('points')->default(0);
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('points_history');
    }
}