<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DeleteRecordLogsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('record_logs');
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
