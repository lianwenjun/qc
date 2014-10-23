<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCatsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cats', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title', 255);
            $table->integer('parent_id')->default(0)->unsigned()->comment('父类分类ID');
            $table->integer('search_total')->default(0)->unsigned()->comment('自然搜索量');
            $table->integer('sort')->default(0)->unsigned()->comment('分类排序');
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
    }

}
