<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('birthday')->after('password');
            $table->integer('role')->after('birthday');
            $table->integer('position_id')->unsigned()->after('role');
            $table->foreign('position_id')->references('id')->on('positions'); 
            $table->softDeletes()->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('birthday');
            $table->dropColumn('role');
            $table->dropForeign(['position_id']);
            $table->dropColumn('deleted_at');
        });
    }
}
