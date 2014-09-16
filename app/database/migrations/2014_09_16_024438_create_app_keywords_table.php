<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppkeywordsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_keywords', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('app_id')->unsigned()->comment('游戏ID');
            $table->integer('keyword_id')->unsigned()->comment('关键词ID');
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
        //Schema::drop('app_keywords');
    }

}
