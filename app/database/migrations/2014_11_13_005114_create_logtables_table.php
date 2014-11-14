<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogtablesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('logs')->create('logtables', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 256)->comment('表名');
            $table->integer('count')->unsigned()->comment('总条数');
            $table->enum('type', [null, 'download', 'page'])->comment('类型');
            $table->timestamp('used_at')->default(null)->nullable()->comment('启用时间');
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
        //Schema::drop('downloads');
    }

}
