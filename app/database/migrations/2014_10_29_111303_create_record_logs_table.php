<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecordLogsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //记录表
        Schema::create('record_logs', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('app_id')->comment('游戏ID');
            $table->string('uuid', 255)->comment('客户端CLIENTID');
            $table->string('type', 255)->comment('用户移动端型号');
            $table->string('imei', 255)->comment('IMEI');
            $table->string('os_version', 255)->comment('系统版本');
            $table->string('ip', 255)->comment('移动端IP');
            $table->enum('status', ['request', 'download', 'install', 'active'])->default('request')->comment('日志类型');
            $table->softDeletes();
            $table->timestamps();
            //时间需要打索引啦
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::drop('record_logs');
    }

}
