<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSortToAppsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apps', function(Blueprint $table)
        {
            if (!Schema::hasColumn('apps', 'sort'))
            {
                $table->integer('sort')->default(0)->after('os_version');
                
                //$table->integer('sort')->comment('排序');
            }
            if (!Schema::hasColumn('apps', 'version_code'))
            {
                $table->string('version_code', 32)->after('version');
                //$table->integer('version_code')->comment('版本代号');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('apps', function(Blueprint $table)
        {
            //
        });*/
    }

}
