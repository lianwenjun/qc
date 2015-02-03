<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePackagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function(Blueprint $table)
        {
            $table->increments('id');
            $table->enum('site', ['wdj', 'yyb', '2345'])->comment('来源网站：豌豆荚、应用宝、2345');
            $table->string('name')->comment('包名');
            $table->string('title')->comment('游戏名');
            $table->integer('version_code')->comment('版本号');
            $table->string('download_link')->comment('下载地址');
            $table->timestamps();
            $table->index(['name', 'site']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('packages');
    }

}
