<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewcatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{	
		// 判断cats表是否存在，若存在则备份cats表
		if (Schema::hasTable('cats'))
		{
		    Schema::rename('cats', 'cats_bak');
		    // 删除可能存在的cats表
		    Schema::dropIfExists('cats');
		    
		}

		Schema::create('cats', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title', 255);
            $table->integer('sort')->default(0)->unsigned()->comment('分类排序');
            $table->enum('position', ['hotcats', 'gamecats'])->default('gamecats')->nullable()->comment('分类位置');
            // 不保留tags冗余字段
            // $table->text('tags')->comment('分类标签');
            $table->integer('operator_id')->default(0)->comment('修改人ID');
            $table->string('operator', 256)->comment('修改人');
            $table->timestamps();
            $table->softDeletes();
        });
			
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cats');
	}

}
