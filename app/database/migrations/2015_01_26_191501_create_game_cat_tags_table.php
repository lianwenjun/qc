<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGameCatTagsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_cat_tags', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('game_id')->default(0)->comment('游戏ID');
            $table->integer('cat_id')->default(0)->comment('分类ID');
            $table->integer('tag_id')->default(0)->comment('标签ID');
            $table->integer('operator_id')->default(0)->comment('修改人ID');
            $table->string('operator', 256)->comment('修改人');
            $table->softDeletes();
            $table->timestamps();


            //打索引
            $table->index('game_id');
            $table->index('cat_id');
            $table->index('tag_id');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('game_cat_tags');
    }

}
