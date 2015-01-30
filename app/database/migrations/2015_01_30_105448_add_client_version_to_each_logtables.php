<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClientVersionToEachLogtables extends Migration {

    /**
     * Run the migrations.
     * 为所有的下载日志原始表添加客户端版本字段
     * @return void
     */
    public function up()
    {
        $logTables = DB::connection('logs')->select("show tables");

        foreach ($logTables as $key => $value) {
            $tableName = $value->{'Tables_in_logs'};

            if ($tableName == 'logtabls' ||
                Schema::connection('logs')->hasColumn($tableName, 'client_version')) {
                continue;
            }

            Schema::connection('logs')->table($tableName, function($table)
            {
                $table->string('client_version', 50)->comment('客户端版本号');
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
        //
    }

}
