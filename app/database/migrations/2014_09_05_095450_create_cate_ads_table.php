<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCateAdsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cate_ads', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title', 255)->comment('分类名');
            $table->string('image', 255)->comment('分类图片');
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
        //Schema::drop('cate_ads');
    }

}
