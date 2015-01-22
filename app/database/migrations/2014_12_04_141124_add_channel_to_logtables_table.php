<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddChannelToLogtablesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $logtable = 'logs.logtables';
        $db = 'logs';
        $names = DB::table($logtable)->select('name')->get();
        foreach ($names as $x) {
            Schema::connection($db)->table($x->name, function(Blueprint $table)
            {
                $table->string('channel', 64)->comment('渠道号');
            });
        }
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
