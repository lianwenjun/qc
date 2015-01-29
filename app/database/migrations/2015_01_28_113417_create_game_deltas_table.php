<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGameDeltasTable extends Migration {

    /**
     * 游戏增量包管理
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_deltas', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('game_id')->default(0)->unsigned()->comment("游戏ID");
            $table->string('from_version')->comment('来源版本');
            $table->string('to_version')->comment('目标版本');
            $table->string('patch_link')->comment('增量包路径');
            $table->integer('from_version_code')->comment('来源版本代号');
            $table->integer('to_version_code')->comment('目标版本代号');
            $table->string('status')->comment('增量包状态');
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
        // Schema::drop('game_deltas');
    }

}
