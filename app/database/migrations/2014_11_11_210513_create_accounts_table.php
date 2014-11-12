<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountsTable extends Migration {

    /**
     * Run the migrations.
     * 手机用户表
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('uuid', 64)->comment('客户端CLIENTID');
            $table->string('type', 64)->comment('用户移动端型号');
            $table->string('imei', 64)->comment('IMEI');
            $table->string('os_version', 64)->comment('系统版本');
            $table->string('os', 64)->comment('用户系统');
            $table->string('channel', 64)->comment('渠道');
            $table->string('ip', 64)->comment('移动端IP');
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
        //Schema::drop('accounts');
    }

}
