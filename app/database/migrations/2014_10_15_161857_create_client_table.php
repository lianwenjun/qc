<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
//本地APP的版本表
class CreateClientTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('download_link', 255)->comment('下载地址');
            $table->string('title', 255)->comment('名称');
            $table->string('md5', 255)->comment('APK文件MD5');
            $table->integer('size_int')->unsigned()->comment('游戏大小');
            $table->text('changes', 255)->comment('更新特性');
            $table->string('version', 255)->comment('版本');
            $table->string('version_code', 255)->comment('系统代号');
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
        //Schema::drop('market');
    }

}
