<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTagsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title', 256)->comment('标签名');
            $table->integer('search_count')->default(0)->comment('搜索量');
            $table->integer('sort')->default(0)->comment('干扰排名');
            $table->integer('operator_id')->default(0)->comment('修改人ID');
            $table->string('operator', 256)->comment('修改人');
            $table->softDeletes();
            $table->timestamps();
            
            $table->index('sort');
            $table->index('search_count');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::drop('tags');
    }

}
