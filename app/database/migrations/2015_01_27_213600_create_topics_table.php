<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTopicsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function(Blueprint $table)
        {
            $table->increments('id');
            $table->text('game_id')->comment('游戏IDS');
            $table->string('title', 256)->comment('专题名');
            $table->string('image', 256)->comment('图片地址');
            $table->text('summary', 256)->comment('专题名');
            $table->string('location', 256)->comment('专题位置');
            //pending => 等待上线 draft => 草稿  stock => 上线状态  unstock => 下线
            $table->enum('status', ['pending', 'draft', 'stock', 'unstock'])->comment('状态');
            $table->integer('sort')->default(0)->comment('排序');
            $table->integer('operator_id')->default(0)->comment('修改人ID');
            $table->string('operator', 256)->comment('修改人');
            $table->timestamp('stocked_at')->comment('上架时间');
            $table->timestamp('unstocked_at')->comment('下架时间');
            
            $table->softDeletes();
            $table->timestamps();

            $table->index('location');
            $table->index('status');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('topics');
    }

}
