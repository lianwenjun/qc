<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DeleteAppRecordsTable extends Migration {

    /**
     * Run the migrations.
     *  删除app_records表
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('app_records');
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::create('app_records', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
        });*/
    }

}
