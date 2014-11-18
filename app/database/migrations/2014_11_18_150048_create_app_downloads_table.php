<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppDownloadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('app_downloads', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('app_id')->comment('游戏ID');
            $table->string('title', 64)->comment('游戏ID');
            $table->string('supplier', 64)->comment('供应商');
            $table->string('cat_id')->comment('游戏分类ID');
            $table->string('cat')->comment('游戏分类');
            $table->integer('request')->default(0)->unsigned()->comment('请求数');
            $table->integer('download')->default(0)->unsigned()->comment('下载数');
            $table->integer('install')->default(0)->unsigned()->comment('安装数');
            $table->integer('active')->default(0)->unsigned()->comment('激活数');
            $table->decimal('download_percent', 5, 2)->default(0)->comment('下载占比(安装量/下载量)');
            $table->date('count_date')->comment('统计日期');
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
		//
	}

}
