<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAppsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('apps', 'size')) {
            DB:query("ALTER TABLE `apps` CHANGE COLUMN `size` `size` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '游戏大小'");
        }   
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

}
