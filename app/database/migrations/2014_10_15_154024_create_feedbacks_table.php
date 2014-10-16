<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
//用户反馈信息表
class CreateFeedbacksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedbacks', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('version', 255)->comment('客户端版本');
            $table->string('content', 500)->comment('反馈内容');
            $table->string('type', 255)->comment('用户移动端型号');
            $table->string('imei', 255)->comment('IMEI');
            $table->string('os_version', 255)->comment('系统版本');
            $table->string('os', 255)->comment('用户系统');
            $table->string('email', 255)->comment('用户邮箱');
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
        //Schema::drop('feedbacks');
    }

}
