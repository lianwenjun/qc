<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// 判断ads表是否存在，若存在则备份ads表
		if (Schema::hasTable('ads'))
		{
		    Schema::rename('ads', 'ads_bak');
		    // 删除可能存在的ads表
		    Schema::dropIfExists('ads');
		}

		Schema::create('ads', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('game_id')->default(0)->comment('游戏ID');
            $table->string('title', 256)->comment('游戏名');
            $table->string('package', 256)->comment('游戏包名');
            $table->string('image', 256)->comment('图片');
            // 首页游戏的,排行游戏,精选游戏,banner,首页图片
            $table->string('location', 256)->comment('广告位置类型');
            // stock => 上架 unstock => 下架
            $table->enum('status', ['stock', 'unstock'])->comment('状态');
            $table->integer('sort')->default(0)->comment('排序');
            $table->integer('operator_id')->default(0)->comment('修改人ID');
            $table->string('operator', 256)->comment('修改人');
            $table->integer('stocked_at')->default(0)->unsigned()->comment('上架时间');
            $table->integer('unstocked_at')->default(0)->unsigned()->comment('下架时间');
            $table->integer('created_at')->default(0)->unsigned()->comment('添加时间');
            $table->integer('updated_at')->default(0)->unsigned()->comment('更新时间');
            $table->integer('deleted_at')->default(NULL)->unsigned()->nullable()->comment('删除时间');
            
            $table->index('location');
            $table->index('sort');
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
