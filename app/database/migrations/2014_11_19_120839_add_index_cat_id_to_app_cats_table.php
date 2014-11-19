<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIndexCatIdToAppCatsTable extends Migration {

    /**
     * Run the migrations.
     *  给游戏分类表的分类ID打索引
     * @return void
     */
    public function up()
    {
        Schema::table('app_cats', function(Blueprint $table)
        {
            $table->index('cat_id');
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
