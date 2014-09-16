<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAppcatesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appcates', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('app_id')->unsigned()->comment('游戏ID');
            $table->integer('cate_id')->unsigned()->comment('分类ID');
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
        //Schema::drop('appcates');
    }

}
