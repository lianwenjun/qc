<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAppsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('icon', 255)->comment('ICON');
            $table->string('title', 255)->comment('游戏名');
            $table->string('pack', 255)->comment('包名');
            $table->string('size', 32)->comment('游戏大小');
            $table->string('version', 63)->comment('游戏版本');                     
            $table->string('keywords', 255)->comment('游戏关键字');
            $table->string('author', 127)->comment('游戏作者');
            $table->text('summary')->comment('游戏简介');
            $table->text('images')->comment('游戏图片');
            $table->text('changes')->comment('游戏特性');
            $table->string('reason', 255)->comment('审核不过原因');           
            $table->integer('download_counts')->default(0)->comment('总下载量');
            $table->string('download_link', 255)->comment('APK下载路径');
            $table->enum('is_onshelf', ['yes', 'no'])->default('no')->comment('是否上架');
            $table->enum('is_review', ['yes', 'no'])->default('no')->comment('是否审核');
            $table->timestamp('onshelfed_at')->comment('上架时间');
            $table->timestamp('offshelfed_at')->comment('下架时间');
            $table->timestamp('reviewed_at')->comment('审核时间');
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
        //Schema::drop('apps');
    }

}
