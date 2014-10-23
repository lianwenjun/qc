<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('app_id');
            $table->string('title', 127)->comment('游戏名');
            $table->string('location', 255)->comment('广告区域');
            $table->string('image', 255)->comment('图片路径');
            $table->string('word', 255)->comment('广告词');
            $table->integer('sort')->default(0)->unsigned()->comment('排序');
            $table->enum('type', ['index', 'app', 'editor', 'rank'])->comment('广告位分类');
            $table->enum('is_restock', ['yes', 'no'])->default('no')->comment('是否上架');
            $table->enum('is_top', ['yes', 'no'])->default('no')->comment('是否置顶');
            $table->timestamp('restocked_at')->comment('上架时间');
            $table->timestamp('unstocked_at')->comment('下架时间');
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
        //Schema::drop('ads');
    }

}
