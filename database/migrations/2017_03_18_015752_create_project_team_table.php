<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_team', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_user_id')->unsigned()->index();
            $table->foreign('team_user_id')->references('id')->on('team_user'); 
            $table->integer('project_id')->unsigned()->index();
            $table->foreign('project_id')->references('id')->on('projects'); 
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
        Schema::dropIfExists('project_team');
    }
}
