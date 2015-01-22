<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChannelsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::dropIfExists('channels');
        
        Schema::create('channels', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('release')->default(0)->unsigned()->comment('releaseID从0开始');
            $table->string('name', 256)->comment('渠道名');
            $table->string('code', 256)->comment('渠道代号');
            
            $table->softDeletes();
            $table->timestamps();
        });

        // 如果表存在 
        if (Schema::hasTable('channels'))
        {
            // 填充数据
            $datas = [
                [
                    'release' => 0,
                    'name' => '游戏中心',
                ],
                [
                    'release' => 1,
                    'name' => '天天游戏中心',
                ],
                [
                    'release' => 2,
                    'name' => '应用宝',
                ],
            ];
            foreach ($datas as $data) {
                Channels::create($data);
            }
        }
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('channels');
    }

}
