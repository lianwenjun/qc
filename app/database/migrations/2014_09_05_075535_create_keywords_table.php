<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKeywordsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keywords', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('word', 255)->comment('关键词');
            $table->integer('search_total')->default(0)->comment('自然搜索量');
            $table->enum('is_slide', ['yes', 'no'])->default('no')->comment('是否轮播');
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
        Schema::drop('keywords');
    }

}
