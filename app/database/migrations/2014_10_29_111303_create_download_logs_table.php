<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDownloadLogsTable extends Migration {

    /**
     * Run the migrations.
     *  APP下载单条记录表
     * @return void
     */
    public function up()
    {
        //记录表
        Schema::connection('logs')->create('download_logs', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('app_id')->comment('游戏ID');
            $table->integer('account_id')->unsigned()->comment('手机用户ID');
            $table->string('ip', 64)->comment('移动端IP');
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
