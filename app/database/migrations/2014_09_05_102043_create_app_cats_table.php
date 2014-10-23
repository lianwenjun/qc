<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAppcatsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_cats', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('app_id')->unsigned()->comment('游戏ID');
            $table->integer('cat_id')->unsigned()->comment('分类ID');
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
