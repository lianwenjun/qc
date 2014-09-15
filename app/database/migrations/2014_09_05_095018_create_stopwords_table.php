<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStopwordsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stopwords', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('word', 16)->comment('替换词');
            $table->string('to_word', 16)->default('**')->comment('目标词');
            $table->integer('creator')->unsigned()->comment('添加人');
            $table->integer('last_editor')->unsigned()->comment('最后修改者');
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
        //Schema::drop('stopwords');
    }

}
