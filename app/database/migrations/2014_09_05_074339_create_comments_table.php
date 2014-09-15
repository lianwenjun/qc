<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('app_id');
            $table->string('title', 128)->comment('游戏名');
            $table->string('pack', 128)->comment('包名');
            $table->string('imei', 32)->comment('用户手机IMEI');
            $table->string('type', 32)->comment('用户机型');
            $table->string('ip', 16)->comment('用户IP');
            $table->string('content', 32)->comment('内容');
            $table->tinyInteger('rating')->comment('评分');
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
        //Schema::drop('comments');
    }

}
