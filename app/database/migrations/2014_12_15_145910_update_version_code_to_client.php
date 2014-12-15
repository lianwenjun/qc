<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateVersionCodeToClient extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client', function(Blueprint $table)
        {
            if (Schema::hasColumn('client', 'version_code')) {
                DB::statement("ALTER TABLE `client` CHANGE `version_code` `version_code` INT(11)  NOT NULL");
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
    }

}
