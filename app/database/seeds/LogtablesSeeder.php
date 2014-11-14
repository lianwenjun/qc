<?php

use Illuminate\Database\Schema\Blueprint;

class LogtablesSeeder extends Seeder {
    
    protected $num = 10; //一次新建表数
    protected $length = 5; //随机长度
    protected $db = 'logs'; //数据库库名，必须配置里有
    
    private function newTable($tableName) {
        if (Schema::connection($this->db)->hasTable($tableName)) {
            return;
        }
        Schema::connection($this->db)->create($tableName, function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('app_id')->comment('游戏ID');
            $table->integer('account_id')->unsigned()->comment('手机用户ID');
            $table->string('ip', 64)->comment('移动端IP');
            $table->enum('status', ['request', 'download', 'install', 'active'])->default('request')->comment('日志类型');
            $table->softDeletes();
            $table->timestamps();
        });
    }
    //获得随机值
    private function getRandom() {
        return str_random($this->length);
    }
    //检查是否总数合格
    private function isNum($random) {
        return count($random) < $this->num;
    }
    /**
     * Run the database seeds.
     * 运行该方法生成10条新的数据在记录表，同时生成10个新的表
     * @return void
     */
    public function run()
    {
        //生成10条内容
        //新建10张表
        $names = DB::table('logs.logtables')->select('name')->get();
        $data = array_map(function($x){
            return $x->name;
        }, $names);
        $random = [];
        while ($this->isNum($random)) {
            $str = $this->getRandom();
            if (!in_array($str, $data)) {
                $random[] = $str;
            }
        }   
        foreach ($random as $name) {
            $data = [
                'name' => $name,
                'count' => '0',
                'type' => 'download',
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ];
            //插入到数据表
            DB::table('logs.logtables')->insert($data);
            //新建表
            $this->newTable($name);
            echo '新建立' . $this->db . '.' . $name . "表\n";
        }        
    }

}