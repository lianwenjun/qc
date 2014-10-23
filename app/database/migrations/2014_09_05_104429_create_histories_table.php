<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHistoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('app_id');
            $table->string('icon', 255)->comment('ICON');
            $table->string('title', 128)->comment('游戏名');
            $table->string('pack', 128)->comment('包名');
            $table->string('size', 20)->comment('游戏大小');
            $table->integer('size_int')->unsigned()->comment('游戏大小查询用');
            $table->string('md5', 32)->comment('APK md5值');
            $table->string('version', 32)->comment('游戏版本');
            $table->string('version_code', 32)->comment('版本代号');
            $table->string('author', 128)->comment('游戏作者');
            $table->text('summary')->comment('游戏简介');
            $table->text('images')->comment('游戏图片');
            $table->text('changes')->comment('游戏特性');
            $table->string('reason', 20)->comment('审核不过原因');
            $table->integer('download_counts')->default(0)->unsigned()->comment('总下载量');
            $table->string('download_manual', 32)->comment('人工用于显示下载量');
            $table->string('download_link', 255)->comment('APK下载路径');
            $table->integer('operator')->comment('操作者');
            $table->string('os', 32)->comment('系统OS');
            $table->string('os_version', 32)->comment('系统版本');
            $table->integer('sort')->default(0)->comment('排序');
            $table->enum('status', ['publish', 'draft', 'pending', 'nopass', 'stock', 'unstock'])->default('publish')->comment('数据状态');
            $table->enum('is_verify', ['yes', 'no'])->default('no')->comment('是否安全认证');
            $table->enum('has_ad', ['yes', 'no'])->default('no')->comment('是否无广告');
            $table->string('source', 10)->comment('来源');
            $table->timestamp('stocked_at')->comment('上架时间');
            $table->timestamp('unstocked_at')->comment('下架时间');
            $table->timestamp('reviewed_at')->comment('审核时间');
            $table->text('cats')->comment('游戏分类');
            $table->text('tags')->comment('游戏标签');
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
        //Schema::drop('histories');
    }

}
