<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRatingTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('app_id');
            $table->string('title', 255)->comment('游戏名');
            $table->string('pack', 255)->comment('包名');
            $table->integer('total')->default(0)->comment('总评分');
            $table->integer('counts')->default(0)->comment('评分次数');
            $table->float('avg')->default(0)->comment('平均分');
            $table->integer('manual')->default(0)->comment('人工权值');          
            $table->softDeletes();
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
        Schema::drop('rating');
    }

}
