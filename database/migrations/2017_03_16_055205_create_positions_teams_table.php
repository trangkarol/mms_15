<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionsTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions_teams', function (Blueprint $table) {
           $table->increments('id');
            $table->integer('users_teams_id')->unsigned()->index();
            $table->foreign('users_teams_id')->references('id')->on('users_teams'); 
            $table->integer('positions_id')->unsigned()->index();
            $table->foreign('positions_id')->references('id')->on('positions'); 
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
        Schema::dropIfExists('positions_teams');
    }
}
