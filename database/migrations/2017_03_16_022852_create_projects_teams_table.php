<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects_teams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_teams_id')->unsigned()->index();
            $table->foreign('users_teams_id')->references('id')->on('users_teams'); 
<<<<<<< 08eee942771e66b72dfb7dcec35a4232954a465f
            $table->integer('projects_id')->unsigned()->index();
            $table->foreign('projects_id')->references('id')->on('projects'); 
=======
            $table->integer('positions_id')->unsigned()->index();
            $table->foreign('positions_id')->references('id')->on('positions'); 
>>>>>>>  task/106729 Init model and relationship .
            $table->tinyInteger('is_leader');
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
        Schema::dropIfExists('projects_teams');
    }
}
