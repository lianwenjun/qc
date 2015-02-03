<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGameHistoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_histories', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('game_id')->default(0)->comment('游戏ID');
            $table->integer('entity_id')->default(0)->comment('第三方ID');
            $table->string('title', 256)->comment('游戏名');
            $table->text('summary')->comment('游戏简介');
            $table->string('author', 32)->comment('作者');
            $table->string('icon', 256)->comment('ICON');
            $table->string('md5', 64)->comment('MD5');
            $table->integer('size')->default(0)->comment('大小');
            $table->string('download_link', 256)->comment('下载链接');
            $table->string('package', 256)->comment('包名');
            $table->text('features')->comment('新特性');
            $table->text('screenshots')->comment('截图列表');
            $table->string('version', 256)->comment('版本');
            $table->integer('version_code')->comment('版本代号');
            $table->string('os', 256)->comment('系统');
            $table->string('os_version', 256)->comment('系统版本');
            $table->integer('creator_id')->default(0)->comment('上传人ID');
            $table->string('creator', 256)->comment('上传人');
            $table->integer('operator_id')->default(0)->comment('修改人ID');
            $table->string('operator', 256)->comment('修改人');
            $table->string('reason', 256)->comment('审核原因');
            $table->string('cats', 256)->comment('类');
            // $table->text('review')->comment('小编点评');
            $table->text('tags')->comment('标签');
            $table->text('keywords')->comment('关键词');
            $table->decimal('rate', 3, 2)->comment('评分');
            $table->integer('comments')->default(0)->comment('评论总数');
            $table->integer('gift_total')->default(0)->comment('礼包总数');
            $table->integer('vendor_id')->comment('供应商ID');
            $table->string('vendor')->comment('供应商代号');
            //
            $table->enum('status', ['history'])->default('history')->nullable()->comment('状态');
            $table->integer('sort')->default(0)->comment('排序');
            $table->integer('download_total')->default(0)->comment('自然统计');
            $table->integer('download_display')->default(0)->comment('显示统计');
            $table->integer('stocked_at')->default(0)->unsigned()->comment('上架时间');
            $table->integer('unstocked_at')->default(0)->unsigned()->comment('下架时间');
            $table->integer('checked_at')->default(0)->unsigned()->comment('审核时间');
            $table->integer('created_at')->default(0)->unsigned()->comment('添加时间');
            $table->integer('updated_at')->default(0)->unsigned()->comment('更新时间');
            $table->integer('deleted_at')->default(NULL)->unsigned()->nullable()->comment('删除时间');
        
            $table->index('game_id');
            $table->index('title');
            $table->index('size');

            $table->engine = 'InnoDB';
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('game_histories');
    }

}
