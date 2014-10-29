<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAppRecordsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_records', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('app_id')->comment('游戏ID');
            $table->integer('request')->default(0)->unsigned()->comment('请求数');
            $table->integer('download')->default(0)->unsigned()->comment('下载数');
            $table->integer('install')->default(0)->unsigned()->comment('安装数');
            $table->integer('active')->default(0)->unsigned()->comment('激活数');
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
        //Schema::drop('app_records');
    }

}
