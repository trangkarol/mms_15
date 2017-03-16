<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('position_team', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_user_id')->unsigned()->index();
            $table->foreign('team_user_id')->references('id')->on('team_user'); 
            $table->integer('position_id')->unsigned()->index();
            $table->foreign('position_id')->references('id')->on('positions'); 
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
        Schema::dropIfExists('position_team');
    }
}
